<?php

namespace Pleets\Tests\Feature\Concerns;

trait HasResponses
{
    use HasContactInfo;

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

        return [
            'domainName' => 'test-domain.org',
            'nameservers' => [
                'ns1vwx.name.com',
                'ns2qvz.name.com',
                'ns3gmv.name.com',
                'ns4hmp.name.com'
            ],
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

        $response = [
            'domain' => [
                'domainName' => 'test-domain.org',
                'nameservers' => [
                    'ns1vwx.name.com',
                    'ns2qvz.name.com',
                    'ns3gmv.name.com',
                    'ns4hmp.name.com'
                ],
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
