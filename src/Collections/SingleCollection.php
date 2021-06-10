<?php

namespace Pleets\NameCom\Collections;

class SingleCollection
{
    protected array $items = [];

    public function add($item): bool
    {
        $key = array_search($item, $this->items);

        if ($key === false) {
            $this->items[] = $item;

            return true;
        }

        return false;
    }

    public function remove($item): bool
    {
        $key = array_search($item, $this->items);

        if ($key !== false) {
            unset($this->items[$key]);
            $this->items = array_values($this->items);

            return true;
        }

        return false;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
