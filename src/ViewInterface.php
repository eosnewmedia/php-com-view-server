<?php
declare(strict_types=1);


namespace Eos\ComView\Server;

use Eos\ComView\Server\Model\Value\ViewRequest;
use Eos\ComView\Server\Model\Value\ViewResponse;


/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
interface ViewInterface
{

    /**
     * @param string $name
     * @param ViewRequest $request
     * @return ViewResponse
     */
    public function create(string $name, ViewRequest $request): ViewResponse;

}