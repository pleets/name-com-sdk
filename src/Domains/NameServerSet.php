<?php

namespace Pleets\NameCom\Domains;

class NameServerSet
{
    protected array $nameservers = [];

    public function addNameServer(string $nameserver): self
    {
        $key = array_search($nameserver, $this->nameservers);

        if ($key === false) {
            $this->nameservers[] = $nameserver;
        }

        return $this;
    }

    public function removeNameServer(string $nameserver): self
    {
        $key = array_search($nameserver, $this->nameservers);

        if ($key !== false) {
            unset($this->nameservers[$key]);
            $this->nameservers = array_values($this->nameservers);
        }

        return $this;
    }

    public function toArray(): array
    {
        return $this->nameservers;
    }
}
