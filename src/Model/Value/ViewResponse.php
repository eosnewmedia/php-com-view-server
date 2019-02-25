<?php
declare(strict_types=1);

namespace Eos\ComView\Server\Model\Value;


/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
class ViewResponse
{
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
     * @param array $parameters
     * @param array $pagination
     * @param array|null $data
     * @param null|string $orderBy
     */
    public function __construct(
        array $parameters = [],
        array $pagination = [],
        ?array $data = null,
        ?string $orderBy = null
    ) {
        $this->parameters = $parameters;
        $this->pagination = $pagination;
        $this->orderBy = $orderBy;
        $this->data = $data;
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
