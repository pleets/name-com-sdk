<?php

namespace Pleets\Tests\Feature;

use EasyHttp\MockBuilder\HttpMock;
use Pleets\NameCom\Domains\Domain;
use Pleets\NameCom\Domains\Requests\CreateDomainRequest;
use Pleets\NameCom\NameComApi;
use Pleets\Tests\Feature\Concerns\HasContactInfo;
use Pleets\Tests\Feature\Concerns\HasMockBuilder;
use Pleets\Tests\TestCase;

class NameComApiTest extends TestCase
{
    use HasMockBuilder;
    use HasContactInfo;

    private const DOMAIN_REGEX = '(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]';
    private string $baseUri = 'https://api.dev.name.com';

    public function setUp(): void
    {
        $this->createBuilder();
        parent::setUp();
    }

    /**
     * @test
     */
    public function itCanGetDomains()
    {
        $info = $this->generateContactInfo();

        $jsonResponse = [
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

        $this->builder
            ->when()
                ->methodIs('GET')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . '/')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);
        ;

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->getDomain('test-domain.org');

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
    }

    /**
     * @test
     */
    public function itCanListDomains()
    {
        $jsonResponse = [
            'domains' => [
                'domainName' => 'example.com',
                'locked' => true,
                'autorenewEnabled' => true,
                'expireDate' => '2022-05-30T07:00:11Z',
                'createDate' => '2021-05-30T07:00:11Z'
            ]
        ];

        $this->builder
            ->when()
                ->methodIs('GET')
                ->pathIs('/v4/domains')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->listDomains();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
    }

    /**
     * @test
     */
    public function itCanCreateADomainWithMinimumData()
    {
        $domain = $this->faker->domainName;

        $info = $this->generateContactInfo();

        $jsonResponse = [
            'domain' => [
                'domainName' => $domain,
                'nameservers' => [
                    'ns1vwx.name.com',
                    'ns2vwx.name.com',
                    'ns3vwx.name.com',
                    'ns4vwx.name.com',
                ],
                'contacts' => [
                    'registrant' => $info,
                    'admin' => $info,
                    'tech' => $info,
                    'billing' => $info,
                ],
                'locked' => true,
                'autorenewEnabled' => true,
                'expireDate' => '2022-06-02T23:39:53Z',
                'createDate' => '2021-06-02T23:39:53Z',
                'renewalPrice' => 14.99
            ],
            'order' => 235841,
            'totalPaid' => 8.99
        ];

        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathIs('/v4/domains')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $request = new CreateDomainRequest(new Domain($domain));

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->createDomain($request);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
    }

    /**
     * @test
     */
    public function itCanCreateADomainWithPurchasePrice()
    {
        $domainName = $this->faker->domainName;

        $info = $this->generateContactInfo();

        $jsonResponse = [
            'domain' => [
                'domainName' => $domainName,
                'nameservers' => [
                    'ns1vwx.name.com',
                    'ns2vwx.name.com',
                    'ns3vwx.name.com',
                    'ns4vwx.name.com',
                ],
                'contacts' => [
                    'registrant' => $info,
                    'admin' => $info,
                    'tech' => $info,
                    'billing' => $info,
                ],
                'locked' => true,
                'autorenewEnabled' => true,
                'expireDate' => '2022-06-02T23:39:53Z',
                'createDate' => '2021-06-02T23:39:53Z',
                'renewalPrice' => 14.99
            ],
            'order' => 235841,
            'totalPaid' => 8.99
        ];

        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathIs('/v4/domains')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $request = new CreateDomainRequest(new Domain($domainName));
        $request->setPurchasePrice(14.99);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->createDomain($request);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
    }
}
