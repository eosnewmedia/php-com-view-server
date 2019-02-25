<?php
declare(strict_types=1);


namespace Eos\ComView\Server;

use Eos\ComView\Server\Exception\ComViewException;
use Eos\ComView\Server\Model\Value\CommandResponse;


/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
class CommandProcessorRegistry implements CommandProcessorInterface
{
    /**
     * @var CommandProcessorInterface[]
     */
    private $commands = [];

    /**
     * @param string $name
     * @param CommandProcessorInterface $command
     * @return void
     */
    public function add(string $name, CommandProcessorInterface $command): void
    {
        $this->commands[$name] = $command;
    }

    /**
     * @param string $name
     * @param array $request
     * @return CommandResponse
     * @throws ComViewException
     */
    public function process(string $name, array $request): CommandResponse
    {
        if (\array_key_exists($name, $this->commands)) {
            return $this->commands[$name]->process($name, $request);
        }

        throw new ComViewException('Command ' . $name . ' not found.');
    }
}
