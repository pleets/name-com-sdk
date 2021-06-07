<?php

namespace Pleets\NameCom\Domains\Requests;

use Pleets\NameCom\Domains\Concerns\HasDomainName;
use Pleets\NameCom\Domains\ContactSet;

class SetContactsRequest
{
    use HasDomainName;

    protected ContactSet $contactSet;

    public function __construct(string $domainName, ContactSet $contactSet)
    {
        $this->domainName = $domainName;
        $this->contactSet = $contactSet;
    }

    public function getContactSet(): ContactSet
    {
        return $this->contactSet;
    }

    public function setContactSet(ContactSet $contactSet): self
    {
        $this->contactSet = $contactSet;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'contacts' => $this->contactSet->toArray()
        ];
    }
}
