<?php

namespace Pleets\Tests\Feature\Domains;

use EasyHttp\MockBuilder\HttpMock;
use Pleets\NameCom\Domains\Domain;
use Pleets\NameCom\Domains\Requests\CreateDomainRequest;
use Pleets\NameCom\NameComApi;
use Pleets\Tests\Feature\Concerns\HasFullDomainModelResponse;
use Pleets\Tests\TestCaseWithMockAuthentication;

class CreateDomainTest extends TestCaseWithMockAuthentication
{
    use HasFullDomainModelResponse;

    /**
     * @test
     */
    public function itCanCreateADomainWithMinimumData()
    {
        $domainName = $this->faker->domainName;
        $jsonResponse = $this->buildFullDomainModelResponseByDomain($domainName);

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
        $jsonResponse = $this->buildFullDomainModelResponseByDomain($domainName);

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
}
