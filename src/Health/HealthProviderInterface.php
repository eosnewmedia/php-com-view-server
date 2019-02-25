<?php
declare(strict_types=1);

namespace Eos\ComView\Server\Health;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
interface HealthProviderInterface
{
    public const AVAILABLE = 'AVAILABLE';

    public const LIMITED = 'LIMITED';

    public const UNAVAILABLE = 'UNAVAILABLE';

    public const UNKNOWN = 'UNKNOWN';
}
