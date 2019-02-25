<?php
declare(strict_types=1);

namespace Eos\ComView\Server\Health;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
interface ViewHealthProviderInterface extends HealthProviderInterface
{
    /**
     * @return string[]
     */
    public function getViewStates(): array;
}
