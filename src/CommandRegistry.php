<?php
declare(strict_types=1);


namespace Eos\ComView\Server;

use Eos\ComView\Server\Exception\ComViewException;
use Eos\ComView\Server\Model\Value\CommandRequest;
use Eos\ComView\Server\Model\Value\CommandResponse;


/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
class CommandRegistry implements CommandInterface
{

    /**
     * @var CommandInterface[]
     */
    private $commands = [];

    /**
     * @param string $name
     * @param CommandRequest $request
     * @return CommandResponse
     * @throws ComViewException
     */
    public function execute(string $name, CommandRequest $request): CommandResponse
    {
        if (\array_key_exists($name, $this->commands)) {
            return $this->commands[$name]->execute($name, $request);
        }

        throw new ComViewException('No Command found :' . $name);
    }

    /**
     * @param string $name
     * @param CommandInterface $command
     * @return CommandInterface
     */
    public function add(string $name, CommandInterface $command): CommandInterface
    {
        $this->commands[$name] = $command;

        return $this;
    }
}
