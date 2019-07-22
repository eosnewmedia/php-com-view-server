<?php
declare(strict_types=1);

namespace Eos\ComView\Server;

use Eos\ComView\Server\Command\CommandProcessorInterface;
use Eos\ComView\Server\Exception\ComViewException;
use Eos\ComView\Server\Health\CommandHealthProviderInterface;
use Eos\ComView\Server\Health\ViewHealthProviderInterface;
use Eos\ComView\Server\Model\Value\CommandRequest;
use Eos\ComView\Server\Model\Value\HttpResponse;
use Eos\ComView\Server\Model\Value\ViewRequest;
use Eos\ComView\Server\View\ViewInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Throwable;

/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
class ComViewServer implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var CommandProcessorInterface
     */
    private $commandProcessor;

    /**
     * @var ViewInterface
     */
    private $view;

    /**
     * @var CommandHealthProviderInterface|null
     */
    private $commandHealthProvider;

    /**
     * @var ViewHealthProviderInterface|null
     */
    private $viewHealthProvider;

    /**
     * @param CommandProcessorInterface $commandProcessor
     * @param ViewInterface $view
     * @param CommandHealthProviderInterface|null $commandHealthProvider
     * @param ViewHealthProviderInterface|null $viewHealthProvider
     */
    public function __construct(
        CommandProcessorInterface $commandProcessor,
        ViewInterface $view,
        ?CommandHealthProviderInterface $commandHealthProvider = null,
        ?ViewHealthProviderInterface $viewHealthProvider = null
    ) {
        $this->commandProcessor = $commandProcessor;
        $this->view = $view;
        $this->commandHealthProvider = $commandHealthProvider;
        $this->viewHealthProvider = $viewHealthProvider;
    }

    /**
     * @return LoggerInterface
     */
    protected function getLogger(): LoggerInterface
    {
        if (!$this->logger) {
            return new NullLogger();
        }

        return $this->logger;
    }

    /**
     * @param string $name
     * @param array $headers
     * @param array $queryParameters
     * @return HttpResponse
     * @throws Throwable
     */
    public function view(string $name, array $headers, array $queryParameters): HttpResponse
    {
        $viewRequest = new ViewRequest(
            $headers,
            array_key_exists('parameters', $queryParameters) ? $queryParameters['parameters'] : [],
            array_key_exists('pagination', $queryParameters) ? $queryParameters['pagination'] : [],
            $queryParameters['orderBy'] ?? null
        );

        try {
            $view = $this->view->createView($name, $viewRequest);

            return new HttpResponse(
                200,
                $view->getHeaders(),
                [
                    'parameters' => $view->getParameters(),
                    'pagination' => $view->getPagination(),
                    'orderBy' => $view->getOrderBy(),
                    'data' => $view->getData(),
                ]
            );
        } catch (ComViewException $exception) {
            if ($exception->isCritical()) {
                $this->getLogger()->critical(
                    $exception->getMessage(),
                    [
                        'status' => $exception->getHttpStatus(),
                        'error' => $exception->getError(),
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                        'stack' => $exception->getTrace()
                    ]
                );
            } else {
                $this->getLogger()->info(
                    $exception->getMessage(),
                    [
                        'status' => $exception->getHttpStatus(),
                        'error' => $exception->getError()
                    ]
                );
            }

            return new HttpResponse($exception->getHttpStatus(), [], $exception->getError());
        } catch (Throwable $exception) {
            $this->getLogger()->emergency(
                $exception->getMessage(),
                [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'stack' => $exception->getTrace()
                ]
            );

            return new HttpResponse(500);
        }
    }

    /**
     * @param array $headers
     * @param array $requestBody
     * @return HttpResponse
     * @throws Throwable
     */
    public function execute(array $headers, array $requestBody): HttpResponse
    {
        $data = [];
        foreach ($requestBody as $id => $command) {
            try {
                $response = $this->commandProcessor->process(
                    $command['command'],
                    new CommandRequest(
                        $headers,
                        array_key_exists('parameters', $command) ? $command['parameters'] : []
                    )
                );
                $data[(string)$id] = [
                    'status' => $response->getStatus(),
                    'result' => $response->getResult(),

                ];
            } catch (ComViewException $exception) {
                if ($exception->isCritical()) {
                    $this->getLogger()->critical(
                        $exception->getMessage(),
                        [
                            'status' => $exception->getHttpStatus(),
                            'error' => $exception->getError(),
                            'file' => $exception->getFile(),
                            'line' => $exception->getLine(),
                            'stack' => $exception->getTrace()
                        ]
                    );
                } else {
                    $this->getLogger()->info(
                        $exception->getMessage(),
                        [
                            'status' => $exception->getHttpStatus(),
                            'error' => $exception->getError()
                        ]
                    );
                }

                $data[(string)$id] = [
                    'status' => 'ERROR',
                    'result' => $exception->getError(),
                ];
            } catch (Throwable $exception) {
                $this->getLogger()->emergency(
                    $exception->getMessage(),
                    [
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                        'stack' => $exception->getTrace()
                    ]
                );

                $data[(string)$id] = [
                    'status' => 'ERROR',
                    'result' => null,
                ];
            }
        }

        return new HttpResponse(200, [], $data);
    }

    /**
     * @return HttpResponse
     */
    public function health(): HttpResponse
    {
        $viewHealth = $this->viewHealthProvider ? $this->viewHealthProvider->getViewStates() : [];
        $commandHealth = $this->commandHealthProvider ? $this->commandHealthProvider->getCommandStates() : [];

        if (count($viewHealth) === 0 && count($commandHealth) === 0) {
            return new HttpResponse(404);
        }

        return new HttpResponse(
            200,
            [],
            [
                'createdAt' => date(DATE_ATOM),
                'views' => $viewHealth,
                'commands' => $commandHealth
            ]
        );
    }
}
