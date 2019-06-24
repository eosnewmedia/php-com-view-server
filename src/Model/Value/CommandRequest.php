<?php
declare(strict_types=1);

namespace Eos\ComView\Server\Model\Value;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class CommandRequest
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
     * @param string[][] $headers
     * @param array $parameters
     */
    public function __construct(array $headers, array $parameters)
    {
        $this->headers = $headers;
        $this->parameters = $parameters;
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
}
