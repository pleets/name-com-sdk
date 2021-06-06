<?php

namespace Pleets\NameCom\Domains\Concerns;

trait HasDomainName
{
    protected string $domainName;

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function setDomainName(string $domainName): self
    {
        $this->domainName = $domainName;

        return $this;
    }
}
