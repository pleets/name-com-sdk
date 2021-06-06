<?php

namespace Pleets\NameCom\Domains\Requests;

use Pleets\NameCom\Domains\Concerns\HasPurchaseYears;
use Pleets\NameCom\Domains\Domain;
use Pleets\NameCom\Domains\Concerns\HasPurchasePrice;

class CreateDomainRequest
{
    use HasPurchasePrice;
    use HasPurchaseYears;

    protected Domain $domain;
    protected ?string $purchaseType = null;

    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }

    public function getDomain(): Domain
    {
        return $this->domain;
    }

    public function setDomain(Domain $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function getPurchaseType(): ?string
    {
        return $this->purchaseType;
    }

    public function setPurchaseType(?string $purchaseType): self
    {
        $this->purchaseType = $purchaseType;

        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'domain' => $this->domain->toArray()
        ];

        if ($this->purchasePrice) {
            $data['purchasePrice'] = $this->purchasePrice;
        }

        if ($this->purchaseType) {
            $data['purchaseType'] = $this->purchaseType;
        }

        if ($this->purchaseYears) {
            $data['years'] = $this->purchaseYears;
        }

        return $data;
    }
}
