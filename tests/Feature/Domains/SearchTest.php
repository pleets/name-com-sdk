<?php

namespace Pleets\Tests\Feature\Domains;

use EasyHttp\MockBuilder\HttpMock;
use Pleets\NameCom\Domains\Requests\SearchRequest;
use Pleets\NameCom\NameComApi;
use Pleets\Tests\Feature\Concerns\HasSearchResultResponse;
use Pleets\Tests\Feature\Concerns\HasTldFilter;
use Pleets\Tests\TestCaseWithMockAuthentication;

class SearchTest extends TestCaseWithMockAuthentication
{
    use HasSearchResultResponse;
    use HasTldFilter;

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
    public function itCanSearchForDomains()
    {
        $domainName1 = $this->faker->domainName;
        $domainName2 = $this->faker->domainName;
        $result1 = [
            'domainName' => $domainName1,
            'sld' => $this->getSld($domainName1),
            'tld' => $this->getTld($domainName1)
        ];
        $result2 = [
            'domainName' => $domainName2,
            'sld' => $this->getSld($domainName2),
            'tld' => $this->getTld($domainName2),
            'purchasable' => true,
            'purchasePrice' => 12.99,
            'purchaseType' => 'registration',
            'renewalPrice' => 12.99
        ];
        $jsonResponse = [
            $result1,
            $result2,
        ];

        $service = $this->setupServiceWithResponse($jsonResponse);

        $request = new SearchRequest($domainName1);
        $response = $service->search($request);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertSame($result1, $response->results()->first()->toArray());
        $this->assertSame($result2, $response->results()->last()->toArray());
    }

    /**
     * @test
     */
    public function itCanSearchForDomainsWithTldFilter()
    {
        $domainName = $this->faker->domainName;
        $result = [
            'domainName' => $domainName,
            'sld' => $this->getSld($domainName),
            'tld' => $this->getTld($domainName),
            'purchasable' => true,
            'purchasePrice' => 12.99,
            'purchaseType' => 'registration',
            'renewalPrice' => 12.99
        ];
        $jsonResponse = [
            $result,
        ];

        $service = $this->setupServiceWithResponse($jsonResponse);

        $request = new SearchRequest($domainName);
        $request->setTldFilter($this->createTldFilter('.net'));
        $response = $service->search($request);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertSame($result, $response->results()->first()->toArray());
    }
}
