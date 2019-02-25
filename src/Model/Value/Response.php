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
     * @var string
     */
    private $body;

    /**
     * @param int $status
     * @param string $body
     */
    public function __construct(int $status, string $body)
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
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }
}
