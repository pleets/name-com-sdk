<?php

namespace Pleets\Tests\Feature\Domains;

use EasyHttp\MockBuilder\HttpMock;
use Pleets\NameCom\Domains\DomainCollection;
use Pleets\NameCom\Domains\Requests\CheckAvailabilityRequest;
use Pleets\NameCom\NameComApi;
use Pleets\Tests\Feature\Concerns\HasSearchResultResponse;
use Pleets\Tests\TestCaseWithMockAuthentication;

class CheckAvailabilityTest extends TestCaseWithMockAuthentication
{
    use HasSearchResultResponse;

    /**
     * @test
     */
    public function itCanCheckAvailability()
    {
        $domainName = $this->faker->domainName;
        $domainName2 = $this->faker->domainName;
        $jsonResponse = $this->buildSearchResultResponse($domainName, $domainName2);

        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathMatch('/v4\/domains:checkAvailability/')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $domainCollection = new DomainCollection();
        $domainCollection->add($domainName);
        $request = new CheckAvailabilityRequest($domainCollection);
        $response = $service->checkAvailability($request);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
    }
}
