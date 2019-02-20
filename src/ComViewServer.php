<?php
declare(strict_types=1);

namespace Eos\ComView\Server;

use Eos\ComView\Server\Exception\ComViewException;
use Eos\ComView\Server\Model\Value\CommandRequest;
use Eos\ComView\Server\Model\Value\ViewRequest;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
class ComViewServer
{
    /**
     * @var ViewInterface
     */
    private $view;

    /**
     * @var CommandInterface
     */
    private $command;

    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;


    /**
     * @param string $name
     * @param array $queryParameters
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function view(string $name, array $queryParameters): ResponseInterface
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
                'pagination' => $view->getPagiantion(),
                'orderBy' => $view->getOrderBy(),
                'data' => $view->getData(),
            ];
        } catch (\Exception $exception) {
            $data = null;
            $status = 404;
        }

        return $this->generateResponse($data, $status);
    }

    /**
     * @param array $requestBody
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function execute(array $requestBody): ResponseInterface
    {
        $data = [];
        foreach ($requestBody as $id => $currentCommand) {
            $commandRequest = new CommandRequest(\array_key_exists('parameters', $data) ? $data['parameters'] : []);
            $response = $this->command->execute($currentCommand['command'], $commandRequest);
            $data[(string)$id] = [
                'status' => $response->getStatus(),
                'result' => $response->getResult(),
            ];
        }

        return $this->generateResponse($data);
    }


    /**
     * @param array $content
     * @param int $code
     * @return ResponseInterface
     * @throws \Throwable
     */
    private function generateResponse(array $content, int $code = 200): ResponseInterface
    {
        try {
            $response = $this->responseFactory->createResponse($code);
            $response
                ->withBody($this->streamFactory->createStream(json_encode($content)))
                ->withHeader('Content-Type', 'application/json');

            return $response;
        } catch (\Throwable $exception) {
            throw  new ComViewException('An error occurred while creating the response', $code, $exception);
        }
    }
}
