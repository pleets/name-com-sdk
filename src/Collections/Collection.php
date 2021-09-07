<?php

namespace Pleets\NameCom\Collections;

class Collection
{
    protected array $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function all(): array
    {
        return $this->items;
    }

    /**
     * @param mixed $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->items)) {
            return $this->items[$key];
        }

        return $default;
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public function has($key): bool
    {
        return array_key_exists($key, $this->items);
    }

    public function push(...$values): self
    {
        foreach ($values as $value) {
            $this->items[] = $value;
        }

        return $this;
    }

    public function forget(...$keys): self
    {
        foreach ($keys as $key) {
            unset($this->items[$key]);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function first()
    {
        foreach ($this->items as $value) {
            return $value;
        }

        return null;
    }

    public function last()
    {
        $items = array_reverse($this->items, true);

        foreach ($items as $value) {
            return $value;
        }

        return null;
    }

    /**
     * @param mixed $value
     * @param bool $strict
     * @return false|int|string
     */
    public function search($value, bool $strict = false)
    {
        return array_search($value, $this->items, $strict);
    }
}
