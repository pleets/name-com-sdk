<?php

namespace Pleets\Tests\Feature\Domains;

use EasyHttp\MockBuilder\HttpMock;
use Pleets\NameCom\Domains\Requests\SearchRequest;
use Pleets\NameCom\Domains\TldCollection;
use Pleets\NameCom\NameComApi;
use Pleets\Tests\Feature\Concerns\HasSearchResultResponse;
use Pleets\Tests\TestCaseWithMockAuthentication;

class SearchTest extends TestCaseWithMockAuthentication
{
    use HasSearchResultResponse;

    private function setupServiceWithResponse(array $response): NameComApi
    {
        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathMatch('/v4\/domains:search/')
            ->then()
                ->statusCode(200)
                ->json($response);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        return $service;
    }

    /**
     * @test
     */
    public function itCanCheckAvailability()
    {
        $domainName = $this->faker->domainName;
        $jsonResponse = $this->buildSearchResultResponse($domainName);
        $service = $this->setupServiceWithResponse($jsonResponse);

        $request = new SearchRequest($domainName);
        $response = $service->search($request);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
    }

    /**
     * @test
     */
    public function itCanCheckAvailabilityWithTldFilter()
    {
        $domainName = $this->faker->domainName;
        $jsonResponse = $this->buildSearchResultResponse($domainName);
        $service = $this->setupServiceWithResponse($jsonResponse);

        $request = new SearchRequest($domainName);
        $tldFilter = new TldCollection();
        $tldFilter->add('net');
        $tldFilter->add('com');
        $response = $service->search($request);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
    }
}
