<?php

namespace Pleets\Tests\Feature;

use EasyHttp\MockBuilder\HttpMock;
use Pleets\NameCom\Domains\Domain;
use Pleets\NameCom\Domains\Requests\CreateDomainRequest;
use Pleets\NameCom\Domains\Requests\RenewDomainRequest;
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

    private function responseWithDomain(string $domainName): array
    {
        return $this->responseWithDomainModel([
            'domain' => [
                'domainName' => $domainName
            ]
        ]);
    }

    /**
     * @test
     */
    public function itCanGetDomains()
    {
        $domainName = $this->faker->domainName;
        $jsonResponse = $this->responseWithDomain($domainName);

        $this->builder
            ->when()
                ->methodIs('GET')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . '/')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->getDomain($domainName);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertSame($domainName, $jsonResponse['domain']['domainName']);
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
        $domainName = $this->faker->domainName;
        $jsonResponse = $this->responseWithDomain($domainName);

        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathIs('/v4/domains')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $request = new CreateDomainRequest(new Domain($domainName));

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->createDomain($request);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertSame($domainName, $jsonResponse['domain']['domainName']);
    }

    /**
     * @test
     */
    public function itCanCreateADomainWithPurchasePrice()
    {
        $domainName = $this->faker->domainName;
        $jsonResponse = $this->responseWithDomain($domainName);

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
        $this->assertSame($domainName, $jsonResponse['domain']['domainName']);
    }

    /**
     * @test
     */
    public function itCanEnableWhoIsPrivacy()
    {
        $jsonResponse = array_replace_recursive($this->response(), [
            'privacyEnabled' => true
        ]);

        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . ':enableWhoisPrivacy/')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->enableWhoIsPrivacy('test-domain.org');

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertTrue($jsonResponse['privacyEnabled']);
    }

    /**
     * @test
     */
    public function itCanDisableWhoIsPrivacy()
    {
        $jsonResponse = array_replace_recursive($this->response(), [
            'privacyEnabled' => false
        ]);

        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . ':disableWhoisPrivacy/')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->disableWhoIsPrivacy('test-domain.org');

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertFalse($jsonResponse['privacyEnabled']);
    }

    /**
     * @test
     */
    public function itCanEnableAutoRenewal()
    {
        $jsonResponse = array_replace_recursive($this->response(), [
            'autorenewEnabled' => true
        ]);

        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . ':enableAutorenew/')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->enableAutoRenewal('test-domain.org');

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertTrue($jsonResponse['autorenewEnabled']);
    }

    /**
     * @test
     */
    public function itCanDisableAutoRenewal()
    {
        $jsonResponse = array_replace_recursive($this->response(), [
            'autorenewEnabled' => false
        ]);

        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . ':disableAutorenew/')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->disableAutoRenewal('test-domain.org');

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertFalse($jsonResponse['autorenewEnabled']);
    }

    /**
     * @test
     */
    public function itCanRenewADomain()
    {
        $domainName = $this->faker->domainName;
        $jsonResponse = $this->responseWithDomain($domainName);

        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . ':renew/')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->renewDomain(new RenewDomainRequest($domainName));

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertSame($domainName, $jsonResponse['domain']['domainName']);
    }

    /**
     * @test
     */
    public function itCanGetDomainAuthCode()
    {
        $jsonResponse = ['authCode' => 'MF6R3u9l3s9k6'];

        $this->builder
            ->when()
                ->methodIs('GET')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . ':getAuthCode/')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->getDomainAuthCode($this->faker->domainName);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
    }

    private function response(): array
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

    private function responseWithDomainModel(array $data = []): array
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
