<?php

namespace Pleets\NameCom\Domains;

use Pleets\NameCom\Domains\Concerns\HasDomainName;

class SearchResult
{
    use HasDomainName;

    protected string $sld;
    protected string $tld;
    protected ?bool $purchasable;
    protected ?float $purchasePrice;
    protected ?string $purchaseType;
    protected ?float $renewalPrice;

    public function __construct(array $data)
    {
        $this->domainName = $data['domainName'];
        $this->sld = $data['sld'];
        $this->tld = $data['tld'];
        $this->purchasable = $data['purchasable'] ?? null;
        $this->purchasePrice = $data['purchasePrice'] ?? null;
        $this->purchaseType = $data['purchaseType'] ?? null;
        $this->renewalPrice = $data['renewalPrice'] ?? null;
    }

    public function getSld(): string
    {
        return $this->sld;
    }

    public function getTld(): string
    {
        return $this->tld;
    }

    public function getPurchasable(): ?bool
    {
        return $this->purchasable;
    }

    public function getPurchasePrice(): ?float
    {
        return $this->purchasePrice;
    }

    public function getPurchaseType(): ?string
    {
        return $this->purchaseType;
    }

    public function getRenewalPrice(): ?float
    {
        return $this->renewalPrice;
    }

    public function toArray(): array
    {
        $data = [
            'domainName' => $this->domainName,
            'sld' => $this->sld,
            'tld' => $this->tld
        ];

        if ($this->purchasable) {
            $data['purchasable'] = $this->purchasable;
        }

        if ($this->purchasePrice) {
            $data['purchasePrice'] = $this->purchasePrice;
        }

        if ($this->purchaseType) {
            $data['purchaseType'] = $this->purchaseType;
        }

        if ($this->renewalPrice) {
            $data['renewalPrice'] = $this->renewalPrice;
        }

        return $data;
    }
}
