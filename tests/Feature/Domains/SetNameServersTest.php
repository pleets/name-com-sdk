<?php

namespace Pleets\Tests\Feature\Domains;

use EasyHttp\MockBuilder\HttpMock;
use Pleets\NameCom\Domains\Requests\SetNameServersRequest;
use Pleets\NameCom\NameComApi;
use Pleets\Tests\Feature\Concerns\HasDomainModelResponses;
use Pleets\Tests\TestCaseWithMockAuthentication;

class SetNameServersTest extends TestCaseWithMockAuthentication
{
    use HasDomainModelResponses;

    /**
     * @test
     */
    public function itSetsEmptyNameServers()
    {
        $domainName = $this->faker->domainName;

        $jsonResponse = $this->buildDomainModelResponse();
        unset($jsonResponse['nameservers']);

        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . ':setNameservers/')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $request = new SetNameServersRequest($domainName);
        $response = $service->setNameServers($request);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertNull($jsonResponse['nameservers'] ?? null);
    }

    /**
     * @test
     */
    public function itSetsNameServers()
    {
        $domainName = $this->faker->domainName;
        $nameServerSet = $this->generateNameServerCollection();

        $jsonResponse = $this->buildDomainModelResponse();
        $jsonResponse['nameservers'] = $nameServerSet->toArray();

        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . ':setNameservers/')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $request = new SetNameServersRequest($domainName);
        $request->setNameServerCollection($nameServerSet);
        $response = $service->setNameServers($request);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertSame($nameServerSet->toArray(), $jsonResponse['nameservers']);
    }
}
