<?php

namespace Pleets\NameCom\Domains\Requests;

use Pleets\NameCom\Domains\Concerns\HasDomainName;
use Pleets\NameCom\Domains\Concerns\HasNameServers;

class SetNameServersRequest
{
    use HasDomainName;
    use HasNameServers;

    protected string $domainName;

    public function __construct(string $domainName)
    {
        $this->domainName = $domainName;
    }

    public function toArray(): array
    {
        if ($this->nameServerSet) {
            return $this->nameServerSet->toArray();
        }

        return [];
    }
}
