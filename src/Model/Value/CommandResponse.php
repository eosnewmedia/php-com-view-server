<?php
declare(strict_types=1);

namespace Eos\ComView\Server\Model\Value;


/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
class CommandResponse
{
    /**
     * @var string
     */
    private $status;

    /**
     * @var array|null
     */
    private $result;

    /**
     * @param string $status
     * @param array|null $result
     */
    public function __construct(string $status, ?array $result = null)
    {
        $this->status = $status;
        $this->result = $result;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return array|null
     */
    public function getResult(): ?array
    {
        return $this->result;
    }


}
