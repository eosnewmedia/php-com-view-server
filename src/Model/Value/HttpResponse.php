<?php
declare(strict_types=1);


namespace Eos\ComView\Server\Model\Value;

/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
class HttpResponse
{
    /**
     * @var int
     */
    private $status;

    /**
     * @var string[][]
     */
    private $headers;

    /**
     * @var array|null
     */
    private $body;

    /**
     * @param int $status
     * @param string[][] $headers
     * @param array|null $body
     */
    public function __construct(int $status, array $headers = [], ?array $body = null)
    {
        $this->status = $status;
        $this->body = $body;
        $this->headers = $headers;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return string[][]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array|null
     */
    public function getBody(): ?array
    {
        return $this->body;
    }
}
