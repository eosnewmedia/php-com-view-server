<?php
declare(strict_types=1);

namespace Eos\ComView\Server\Exception;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class CommandNotFoundException extends ComViewException
{
    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct('Command "' . $name . '" not found.');
    }

    /**
     * @return bool
     */
    public function isCritical(): bool
    {
        return false;
    }

    /**
     * @return int
     */
    public function getHttpStatus(): int
    {
        return 404;
    }
}
