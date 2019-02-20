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
    private $pagiantion;

    /**
     * @var string|null
     */
    private $orderBy;

    /**
     * @param array $parameters
     * @param array $pagiantion
     * @param null|string $orderBy
     */
    public function __construct(array $parameters, array $pagiantion, ?string $orderBy = null)
    {
        $this->parameters = $parameters;
        $this->pagiantion = $pagiantion;
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
    public function getPagiantion(): array
    {
        return $this->pagiantion;
    }

    /**
     * @return null|string
     */
    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }


}
