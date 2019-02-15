<?php
declare(strict_types=1);


namespace Eos\ComView\Server\Model\Common;

/**
 * @author Paul Martin Gütschow <guetschow@esonewmedia.de>
 */
class KeyValueCollection extends AbstractCollection implements KeyValueCollectionInterface
{
    /**
     * @var array
     */
    private $keyMap = [];

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct();
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists(strtolower($key), $this->keyMap) &&
            array_key_exists($this->keyMap[strtolower($key)], $this->collection);
    }

    /**
     * @param string $key
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function getRequired(string $key)
    {
        if (!$this->has($key)) {
            throw new \InvalidArgumentException('Element '.$key.' does not exist');
        }

        return $this->collection[$this->keyMap[strtolower($key)]];
    }

    /**
     * @param string $key
     * @param mixed $defaultValue
     * @return mixed
     */
    public function getOptional(string $key, $defaultValue = null)
    {
        return $this->has($key) ? $this->collection[$this->keyMap[strtolower($key)]] : $defaultValue;
    }

    /**
     * Returns a (sub) collection for an array value from the current collection.
     * If the same sub collection is requested multiple times, each time the same object must be returned
     *
     * @param string $key
     * @param bool $required
     * @return KeyValueCollectionInterface
     * @throws \InvalidArgumentException
     */
    public function createSubCollection(string $key, bool $required = true): KeyValueCollectionInterface
    {
        $data = $required ? $this->getRequired($key) : $this->getOptional($key, []);
        if (!\is_array($data)) {
            throw new \InvalidArgumentException('Element '.$key.' have to be an array to use it as collection.');
        }

        return new self($data);
    }

    /**
     * @param array $data
     * @param bool $overwrite
     * @return KeyValueCollectionInterface
     */
    public function merge(array $data, bool $overwrite = true): KeyValueCollectionInterface
    {
        foreach ($data as $key => $value) {
            if ($overwrite || $this->getOptional($key) === null) {
                $this->set($key, $value);
            }
        }

        return $this;
    }

    /**
     * @param KeyValueCollectionInterface $collection
     * @param bool $overwrite
     * @return KeyValueCollectionInterface
     */
    public function mergeCollection(
        KeyValueCollectionInterface $collection,
        bool $overwrite = true
    ): KeyValueCollectionInterface {
        $this->merge($collection->all(), $overwrite);

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return KeyValueCollectionInterface
     */
    public function set(string $key, $value): KeyValueCollectionInterface
    {
        $this->keyMap[strtolower($key)] = $key;
        if ($value instanceof KeyValueCollectionInterface) {
            $value = $value->all();
        }
        $this->collection[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return KeyValueCollectionInterface
     */
    public function remove(string $key): KeyValueCollectionInterface
    {
        if ($this->has($key)) {
            unset($this->collection[$this->keyMap[strtolower($key)]], $this->keyMap[strtolower($key)]);
        }

        return $this;
    }
}
