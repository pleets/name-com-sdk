<?php

namespace Pleets\NameCom\Domains\Requests;

use Pleets\NameCom\Domains\Concerns\HasDomainName;
use Pleets\NameCom\Domains\Concerns\HasNameServers;

class SetNameServersRequest
{
    use HasDomainName;
    use HasNameServers;

    public function __construct(string $domainName)
    {
        $this->domainName = $domainName;
    }

    public function toArray(): array
    {
        if ($this->nameServerCollection) {
            return $this->nameServerCollection->toArray();
        }

        return [];
    }
}
