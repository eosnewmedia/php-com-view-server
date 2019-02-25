<?php
declare(strict_types=1);

namespace Eos\ComView\Server\Exception;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class ViewNotFoundException extends ComViewException
{
    public function __construct(string $name)
    {
        parent::__construct('View "' . $name . '" not found.');
    }
}
