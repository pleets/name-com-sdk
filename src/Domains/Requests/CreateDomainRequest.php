<?php

namespace Pleets\NameCom\Domains\Requests;

class CreateDomainRequest
{
    protected string $domainName;
    protected ?string $purchasePrice;

    public function __construct(string $domainName, string $purchasePrice = null)
    {
        $this->domainName = $domainName;
        $this->purchasePrice = $purchasePrice;
    }

    public function toArray(): array
    {
        $data = [
            'domain' => [
                'domainName' => $this->domainName
            ]
        ];

        if ($this->purchasePrice) {
            $data['purchasePrice'] = $this->purchasePrice;
        }

        return $data;
    }
}
