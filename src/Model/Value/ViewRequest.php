<?php
declare(strict_types=1);

namespace Eos\ComView\Server\Model\Value;


/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
class ViewRequest
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
     * @param array $parameters
     * @param array $pagination
     * @param null|string $orderBy
     */
    public function __construct(array $parameters = [], array $pagination = [], ?string $orderBy = null)
    {
        $this->parameters = $parameters;
        $this->pagination = $pagination;
        $this->orderBy = $orderBy;
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
     * @return null|string
     */
    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }
}
