<?php

namespace Pleets\NameCom\Domains\Requests;

use Pleets\NameCom\Domains\Domain;

class CreateDomainRequest
{
    protected Domain $domain;
    protected ?string $purchasePrice = null;
    protected ?string $purchaseType = null;
    protected ?int $years = 1;

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

    public function getPurchasePrice(): ?string
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(?string $purchasePrice): self
    {
        $this->purchasePrice = $purchasePrice;

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

    public function getYears(): ?int
    {
        return $this->years;
    }

    public function setYears(?int $years): self
    {
        $this->years = $years;

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

        if ($this->years) {
            $data['years'] = $this->years;
        }

        return $data;
    }
}
