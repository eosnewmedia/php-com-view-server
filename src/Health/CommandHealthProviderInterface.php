<?php
declare(strict_types=1);

namespace Eos\ComView\Server\Health;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
interface CommandHealthProviderInterface extends HealthProviderInterface
{
    /**
     * @return string[]
     */
    public function getCommandStates(): array;
}
