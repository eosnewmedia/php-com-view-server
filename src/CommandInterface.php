<?php
declare(strict_types=1);


namespace Eos\ComView\Server;

use Eos\ComView\Server\Model\Value\CommandRequest;
use Eos\ComView\Server\Model\Value\CommandResponse;


/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
interface CommandInterface
{

    /**
     * @param string $name
     * @param CommandRequest $request
     * @return CommandResponse
     */
    public function execute(string $name, CommandRequest $request): CommandResponse;

}
