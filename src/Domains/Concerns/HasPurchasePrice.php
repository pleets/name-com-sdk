<?php

namespace Pleets\NameCom\Domains\Concerns;

trait HasPurchasePrice
{
    protected ?string $purchasePrice = null;

    public function getPurchasePrice(): ?string
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(?string $purchasePrice): self
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }
}
