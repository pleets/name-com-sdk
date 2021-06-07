<?php

namespace Pleets\Tests\Feature\Concerns;

trait HasResponses
{
    use HasContactInfo;
    use HasNameServers;

    protected function responseWithDomain(string $domainName): array
    {
        return $this->responseWithDomainModel([
            'domain' => [
                'domainName' => $domainName
            ]
        ]);
    }

    protected function response(): array
    {
        $info = $this->generateContactInfo();
        $nameservers = $this->generateNameServerSet();

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

    protected function responseWithDomainModel(array $data = []): array
    {
        $info = $this->generateContactInfo();
        $nameservers = $this->generateNameServerSet();

        $response = [
            'domain' => [
                'domainName' => 'test-domain.org',
                'nameservers' => $nameservers->toArray(),
                'contacts' => [
                    'registrant' => $info,
                    'admin' => $info,
                    'tech' => $info,
                    'billing' => $info,
                ],
                'locked' => true,
                'autorenewEnabled' => true,
                'expireDate' => '2022-05-30T07:00:11Z',
                'createDate' => '2021-05-30T07:00:11Z',
                'renewalPrice' => 12.99
            ],
            'order' => 235151,
            'totalPaid' => 8.99
        ];

        return array_replace_recursive($response, $data);
    }
}
