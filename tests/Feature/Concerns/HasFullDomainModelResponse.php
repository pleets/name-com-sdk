<?php

namespace Pleets\Tests\Feature\Concerns;

trait HasFullDomainModelResponse
{
    use HasContactInfo;
    use HasNameServers;

    protected function buildFullDomainModelResponseByDomain(string $domainName): array
    {
        return $this->buildFullDomainModelResponse([
            'domain' => [
                'domainName' => $domainName
            ]
        ]);
    }

    protected function buildFullDomainModelResponse(array $data = []): array
    {
        $info = $this->generateContactInfo();
        $nameservers = $this->generateNameServerCollection();

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
