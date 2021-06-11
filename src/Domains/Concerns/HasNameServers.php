<?php

namespace Pleets\NameCom\Domains\Concerns;

use Pleets\NameCom\Domains\NameServerCollection;

trait HasNameServers
{
    protected ?NameServerCollection $nameServerCollection = null;

    public function getNameServerCollection(): NameServerCollection
    {
        return $this->nameServerCollection;
    }

    public function setNameServerCollection(NameServerCollection $nameServerSet): self
    {
        $this->nameServerCollection = $nameServerSet;

        return $this;
    }
}
