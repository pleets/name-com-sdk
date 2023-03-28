<?php

namespace Pleets\Tests\Feature\Domains;

use EasyHttp\MockBuilder\HttpMock;
use Pleets\NameCom\NameComApi;
use Pleets\Tests\Feature\Concerns\HasFullDomainModelResponse;
use Pleets\Tests\TestCaseWithMockAuthentication;

class GetPricingForDomainTest extends TestCaseWithMockAuthentication
{
    use HasFullDomainModelResponse;

    /**
     * @test
     */
    public function itCanGetPricingForDomain()
    {
        $domainName = $this->faker->domainName;

        $jsonResponse = [
            'purchasePrice' => 12.99,
            'renewPrice' => 15.99,
            'transferPrice' => 9.99,
        ];

        $this->setMockBuilderForPricing($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->getPricingForDomain($domainName);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
    }

    /**
     * @test
     */
    public function getPricingForSpecifiedYearsDomain()
    {
        $domainName = $this->faker->domainName;

        $jsonResponse = [
            'purchasePrice' => 25.98,
            'renewPrice' => 31.98,
            'transferPrice' => 9.99,
        ];

        $this->setMockBuilderForPricing($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->getPricingForDomain($domainName, 2);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
    }

    private function setMockBuilderForPricing(array $jsonResponse): void
    {
        $this->builder
            ->when()
                ->methodIs('GET')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . ':getPricing/')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);
    }
}
