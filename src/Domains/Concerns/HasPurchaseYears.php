<?php

namespace Pleets\NameCom\Domains\Concerns;

trait HasPurchaseYears
{
    protected ?int $purchaseYears = 1;

    public function getPurchaseYears(): ?int
    {
        return $this->purchaseYears;
    }

    public function setPurchaseYears(?int $purchaseYears): self
    {
        $this->purchaseYears = $purchaseYears;

        return $this;
    }
}
