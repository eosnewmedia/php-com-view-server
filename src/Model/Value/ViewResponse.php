<?php
declare(strict_types=1);

namespace Eos\ComView\Server\Model\Value;


/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
class ViewResponse
{
    /**
     * @var string[][]
     */
    private $headers;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var array
     */
    private $pagination;

    /**
     * @var string|null
     */
    private $orderBy;

    /**
     * @var array| null
     */
    private $data;

    /**
     * @param string[][] $headers
     * @param array $parameters
     * @param array $pagination
     * @param array|null $data
     * @param null|string $orderBy
     */
    public function __construct(
        array $headers = [],
        array $parameters = [],
        array $pagination = [],
        ?array $data = null,
        ?string $orderBy = null
    ) {
        $this->headers = $headers;
        $this->parameters = $parameters;
        $this->pagination = $pagination;
        $this->orderBy = $orderBy;
        $this->data = $data;
    }

    /**
     * @return string[][]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return array
     */
    public function getPagination(): array
    {
        return $this->pagination;
    }

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @return null|string
     */
    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }
}
