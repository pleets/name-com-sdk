<?php

namespace Pleets\Tests;

use EasyHttp\MockBuilder\HttpMock;
use Pleets\NameCom\NameComApi;
use Pleets\Tests\Concerns\HasMockBuilder;

class NameComApiTest extends TestCase
{
    use HasMockBuilder;

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
        $info = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'companyName' => $this->faker->address,
            'address1' => $this->faker->name,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => $this->faker->postcode,
            'country' => $this->faker->countryCode,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email
        ];

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
}
