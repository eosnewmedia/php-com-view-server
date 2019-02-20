<?php
declare(strict_types=1);

namespace Eos\ComView\Server;

use Eos\ComView\Server\Exception\ComViewException;
use Eos\ComView\Server\Model\Value\Response;
use Eos\ComView\Server\Model\Value\ViewRequest;

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
                'pagination' => $view->getPagiantion(),
                'orderBy' => $view->getOrderBy(),
                'data' => $view->getData(),
            ];
        } catch (\Throwable $exception) {
            $data = null;
            $status = 404;
        }

        return $this->generateResponse($status, $data);
    }

    /**
     * @param array $requestBody
     * @return Response
     * @throws \Throwable
     */
    public function execute(array $requestBody): Response
    {
        $data = [];
        foreach ($requestBody as $id => $currentCommand) {
            try {
                $response = $this->command->process(
                    $currentCommand['command'],
                    \array_key_exists('parameters', $currentCommand) ? $currentCommand['parameters'] : []
                );
                $data[(string)$id] = [
                    'status' => $response->getStatus(),
                    'result' => $response->getResult(),
                ];

            } catch (\Throwable $exception) {
                $data[(string)$id] = [
                    'status' => 'ERROR',
                    'result' => null,
                ];
            }
        }

        return $this->generateResponse(200, $data);

    }


    /**
     * @param int $code
     * @param array|null $content
     * @return Response
     * @throws ComViewException
     */
    private function generateResponse(int $code = 200, ?array $content = null): Response
    {
        try {
            return new Response($code, json_encode($content));
        } catch (\Throwable $exception) {
            throw  new ComViewException('An error occurred while creating the response', $code, $exception);
        }
    }
}
