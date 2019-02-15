<?php
declare(strict_types=1);

namespace Eos\ComView\Server\Model\Value;

use Eos\ComView\Server\Model\Common\KeyValueCollectionInterface;

/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
class ViewRequest
{

    /**
     * @var KeyValueCollectionInterface
     */
    private $parameters;


    /**
     * @var KeyValueCollectionInterface
     */
    private $pagiantion;

    /**
     * @var string|null
     */
    private $orderBy;

    /**
     * @param KeyValueCollectionInterface $parameters
     * @param KeyValueCollectionInterface $pagiantion
     * @param null|string $orderBy
     */
    public function __construct(KeyValueCollectionInterface $parameters, KeyValueCollectionInterface $pagiantion, ?string $orderBy)
    {
        $this->parameters = $parameters;
        $this->pagiantion = $pagiantion;
        $this->orderBy = $orderBy;
    }


    /**
     * @return KeyValueCollectionInterface
     */
    public function getParameters(): KeyValueCollectionInterface
    {
        return $this->parameters;
    }

    /**
     * @return KeyValueCollectionInterface
     */
    public function getPagiantion(): KeyValueCollectionInterface
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
