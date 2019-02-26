<?php
declare(strict_types=1);

namespace Eos\ComView\Server\Exception;

use Throwable;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class InvalidRequestException extends ComViewException
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable $previous
     */
    public function __construct(string $message = 'Invalid request!', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
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
        return 400;
    }
}
