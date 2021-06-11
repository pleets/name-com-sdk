<?php

namespace Pleets\Tests\Feature\Concerns;

trait HasSearchResultResponse
{
    protected function buildSearchResultResponse(string ...$domains): array
    {
        $response = [];

        foreach ($domains as $key => $domain) {
            $response[] = ($key % 2 == 0) ? $this->simpleInfo($domain) : $this->completeInfo($domain);
        }

        return $response;
    }

    private function simpleInfo(string $domain): array
    {
        return [
            'domainName' => $domain,
            'sld' => $this->getSld($domain),
            'tld' => $this->getTld($domain)
        ];
    }

    private function completeInfo(string $domain): array
    {
        return [
            'domainName' => $domain,
            'sld' => $this->getSld($domain),
            'tld' => $this->getTld($domain),
            'purchasable' => true,
            'purchasePrice' => 12.99,
            'purchaseType' => 'registration',
            'renewalPrice' => 12.99
        ];
    }

    private function getSld(string $domain): string
    {
        return strstr($domain, '.', true);
    }

    private function getTld(string $domain): string
    {
        return str_replace('.', '', strstr($domain, '.'));
    }
}
