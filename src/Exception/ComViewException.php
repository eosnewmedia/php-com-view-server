<?php
declare(strict_types=1);


namespace Eos\ComView\Server\Exception;

/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
class ComViewException extends \Exception
{
    /**
     * @return int
     */
    public function getHttpStatus(): int
    {
        return 500;
    }

    /**
     * @return bool
     */
    public function isCritical(): bool
    {
        return true;
    }

    /**
     * @return array|null
     */
    public function getError(): ?array
    {
        return null;
    }
}
