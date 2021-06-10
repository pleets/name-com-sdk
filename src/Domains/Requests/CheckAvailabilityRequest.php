<?php

namespace Pleets\NameCom\Domains\Requests;

use Pleets\NameCom\Domains\DomainCollection;

class CheckAvailabilityRequest
{
    protected DomainCollection $domainCollection;

    public function __construct(DomainCollection $domainCollection)
    {
        $this->domainCollection = $domainCollection;
    }

    public function getDomainCollection(): DomainCollection
    {
        return $this->domainCollection;
    }

    public function setDomainCollection(DomainCollection $domainCollection): void
    {
        $this->domainCollection = $domainCollection;
    }

    public function toArray(): array
    {
        return [
            'domainNames' => $this->domainCollection->toArray()
        ];
    }
}
