<?php

namespace Pleets\NameCom\Domains\Concerns;

use Pleets\NameCom\Domains\NameServerSet;

trait HasNameServers
{
    protected ?NameServerSet $nameServerSet = null;

    public function getNameServerSet(): NameServerSet
    {
        return $this->nameServerSet;
    }

    public function setNameServerSet(NameServerSet $nameServerSet): self
    {
        $this->nameServerSet = $nameServerSet;

        return $this;
    }
}
