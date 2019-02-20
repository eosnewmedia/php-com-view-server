<?php
declare(strict_types=1);


namespace Eos\ComView\Server;

use Eos\ComView\Server\Exception\ComViewException;
use Eos\ComView\Server\Model\Value\ViewRequest;
use Eos\ComView\Server\Model\Value\ViewResponse;


/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
class ViewRegistry implements ViewInterface
{

    /**
     * @var ViewInterface[]
     */
    private $views = [];

    /**
     * @param string $name
     * @param ViewRequest $request
     * @return ViewResponse
     * @throws ComViewException
     */
    public function createView(string $name, ViewRequest $request): ViewResponse
    {
        if (\array_key_exists($name, $this->views)) {
            return $this->views[$name]->createView($name, $request);
        }

        throw new ComViewException('No View found :' . $name);
    }

    /**
     * @param string $name
     * @param ViewInterface $view
     * @return ViewInterface
     */
    public function add(string $name, ViewInterface $view): ViewInterface
    {
        $this->views[$name] = $view;

        return $this;
    }
}
