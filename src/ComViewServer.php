<?php
declare(strict_types=1);

namespace Eos\ComView\Server;

use Eos\ComView\Server\Exception\CommandNotFoundException;
use Eos\ComView\Server\Exception\ViewNotFoundException;
use Eos\ComView\Server\Model\Value\Response;
use Eos\ComView\Server\Model\Value\ViewRequest;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
class ComViewServer implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var ViewInterface
     */
    private $view;

    /**
     * @var CommandProcessorInterface
     */
    private $commandProcessor;

    /**
     * @param ViewInterface $view
     * @param CommandProcessorInterface $commandProcessor
     */
    public function __construct(ViewInterface $view, CommandProcessorInterface $commandProcessor)
    {
        $this->view = $view;
        $this->commandProcessor = $commandProcessor;
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
     * @param array $queryParameters
     * @return Response
     * @throws \Throwable
     */
    public function view(string $name, array $queryParameters): Response
    {
        $status = 200;
        $viewRequest = new ViewRequest(
            \array_key_exists('parameters', $queryParameters) ? $queryParameters['parameters'] : [],
            \array_key_exists('pagination', $queryParameters) ? $queryParameters['pagination'] : [],
            $queryParameters['orderBy'] ?? null
        );

        try {
            $view = $this->view->createView($name, $viewRequest);

            $data = [
                'parameters' => $view->getParameters(),
                'pagination' => $view->getPagination(),
                'orderBy' => $view->getOrderBy(),
                'data' => $view->getData(),
            ];

            return new Response($status, $data);
        } catch (ViewNotFoundException $exception) {
            $this->getLogger()->info($exception->getMessage());

            return new Response(404);
        } catch (\Throwable $exception) {
            $this->getLogger()->alert(
                $exception->getMessage(),
                [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'stack' => $exception->getTrace()
                ]
            );

            return new Response(500);
        }
    }

    /**
     * @param array $requestBody
     * @return Response
     * @throws \Throwable
     */
    public function execute(array $requestBody): Response
    {
        $data = [];

        foreach ($requestBody as $id => $command) {
            try {
                $response = $this->commandProcessor->process(
                    $command['command'],
                    \array_key_exists('parameters', $command) ? $command['parameters'] : []
                );
                $data[(string)$id] = [
                    'status' => $response->getStatus(),
                    'result' => $response->getResult(),

                ];
            } catch (CommandNotFoundException $exception) {
                $this->getLogger()->alert($exception->getMessage());

                $data[(string)$id] = [
                    'status' => 'ERROR',
                    'result' => null,
                ];
            } catch (\Throwable $exception) {
                $this->getLogger()->error(
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

        return new Response(200, $data);
    }
}
