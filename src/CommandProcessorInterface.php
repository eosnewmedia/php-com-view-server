<?php
declare(strict_types=1);

namespace Eos\ComView\Server;

use Eos\ComView\Server\Model\Value\CommandResponse;


/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
interface CommandProcessorInterface
{
    /**
     * @param string $name
     * @param array $request
     * @return CommandResponse
     */
    public function process(string $name, array $request): CommandResponse;
}
