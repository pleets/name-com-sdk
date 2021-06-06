<?php

namespace Pleets\NameCom\Domains\Requests;

use Pleets\NameCom\Domains\Concerns\HasDomainName;
use Pleets\NameCom\Domains\Concerns\HasPurchasePrice;
use Pleets\NameCom\Domains\Concerns\HasPurchaseYears;

class RenewDomainRequest
{
    use HasDomainName;
    use HasPurchasePrice;
    use HasPurchaseYears;

    protected string $domainName;

    public function __construct(string $domainName)
    {
        $this->domainName = $domainName;
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->purchasePrice) {
            $data['purchasePrice'] = $this->purchasePrice;
        }

        if ($this->purchaseYears) {
            $data['years'] = $this->purchaseYears;
        }

        return $data;
    }
}
