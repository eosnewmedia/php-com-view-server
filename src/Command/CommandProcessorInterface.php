<?php
declare(strict_types=1);

namespace Eos\ComView\Server\Command;

use Eos\ComView\Server\Exception\CommandNotFoundException;
use Eos\ComView\Server\Model\Value\CommandRequest;
use Eos\ComView\Server\Model\Value\CommandResponse;


/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
interface CommandProcessorInterface
{
    /**
     * @param string $name
     * @param CommandRequest $request
     * @return CommandResponse
     * @throws CommandNotFoundException
     */
    public function process(string $name, CommandRequest $request): CommandResponse;
}
