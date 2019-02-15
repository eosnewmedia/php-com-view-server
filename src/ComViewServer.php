<?php
declare(strict_types=1);

namespace Eos\ComView\Server;

use Eos\ComView\Server\Model\Common\KeyValueCollection;
use Eos\ComView\Server\Model\Value\CommandRequest;
use Eos\ComView\Server\Model\Value\ViewRequest;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

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
     * @param ViewInterface $view
     * @param CommandInterface $command
     */
    public function __construct(ViewInterface $view, CommandInterface $command)
    {
        $this->view = $view;
        $this->command = $command;
    }


    /**
     * @param string $name
     * @param array $parameters
     * @return ResponseInterface
     */
    public function createView(string $name, array $parameters): ResponseInterface
    {
        $status = 200;

        $viewRequest = new ViewRequest(
            new KeyValueCollection(\array_key_exists('parameters', $parameters) ? $parameters['parameters'] : []),
            new KeyValueCollection(\array_key_exists('pagination', $parameters) ? $parameters['pagination'] : []),
            $parameters['orderBy'] ?? null
        );

        try {
            $view = $this->view->create($name, $viewRequest);

            $data = [
                'parameters' => $view->getParameters()->all(),
                'pagination' => $view->getPagiantion()->all(),
                'orderBy' => $view->getOrderBy(),
                'data' => $view->getData()->all(),
            ];
        } catch (\Exception $exception) {
            $data = null;
            $status = 404;
        }

        return $this->generateResponse($data, $status);
    }

    /**
     * @param array $requestData
     * @return ResponseInterface
     */
    public function executeCommand(array $requestData): ResponseInterface
    {
        $data = [];
        foreach ($requestData as $id => $currentCommand) {
            $commandRequest = new CommandRequest(new KeyValueCollection(\array_key_exists('parameters', $data) ? $data['parameters'] : []));

            try {
                $response = $this->command->execute($currentCommand['command'], $commandRequest);
                $data[$id] = [
                    'status' => $response->getStatus(),
                    'result' => $response->getResult()->all(),
                ];
            } catch (\Exception $exception) {

            }
        }

        return $this->generateResponse($data);
    }


    /**
     * @param array $content
     * @param int $code
     * @param array $headers
     * @return ResponseInterface
     */
    private function generateResponse(array $content, int $code = 200, array $headers = ['Content-Type' => 'application/json']): ResponseInterface
    {
        return new Response(
            $code,
            $headers,
            json_encode($content)
        );
    }


}
