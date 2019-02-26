<?php
declare(strict_types=1);


namespace Eos\ComView\Server\Model\Value;

/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
class Response
{
    /**
     * @var int
     */
    private $status;

    /**
     * @var array|null
     */
    private $body;

    /**
     * @param int $status
     * @param array|null $body
     */
    public function __construct(int $status, ?array $body = null)
    {
        $this->status = $status;
        $this->body = $body;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return array|null
     */
    public function getBody(): ?array
    {
        return $this->body;
    }
}
