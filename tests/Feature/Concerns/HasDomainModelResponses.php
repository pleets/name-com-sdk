<?php

namespace Pleets\Tests\Feature\Concerns;

trait HasDomainModelResponses
{
    use HasContactInfo;
    use HasNameServers;

    protected function buildDomainModelResponse(): array
    {
        $info = $this->generateContactInfo();
        $nameservers = $this->generateNameServerCollection();

        return [
            'domainName' => 'test-domain.org',
            'nameservers' => $nameservers->toArray(),
            'contacts' => [
                'registrant' => $info,
                'admin' => $info,
                'tech' => $info,
                'billing' => $info,
            ],
            'privacyEnabled' => true,
            'locked' => true,
            'autorenewEnabled' => true,
            'expireDate' => '2022-05-30T07:00:11Z',
            'createDate' => '2021-05-30T07:00:11Z',
            'renewalPrice' => 12.99
        ];
    }
}
