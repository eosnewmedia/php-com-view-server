<?php
declare(strict_types=1);

namespace Eos\ComView\Server\Model\Value;

use Eos\ComView\Server\Model\Common\CollectionInterface;

/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
class CommandRequest
{

    /**
     * @var CollectionInterface
     */
    private $parameters;

    /**
     * @param CollectionInterface $parameters
     */
    public function __construct(CollectionInterface $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return CollectionInterface
     */
    public function getParameters(): ?CollectionInterface
    {
        return $this->parameters;
    }


}
