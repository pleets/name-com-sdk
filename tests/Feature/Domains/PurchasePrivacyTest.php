<?php

namespace Pleets\Tests\Feature\Domains;

use EasyHttp\MockBuilder\HttpMock;
use Pleets\NameCom\Domains\Requests\PurchaseRequest;
use Pleets\NameCom\NameComApi;
use Pleets\Tests\TestCaseWithMockAuthentication;

class PurchasePrivacyTest extends TestCaseWithMockAuthentication
{
    private function setupServiceWithResponse(array $response): NameComApi
    {
        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . ':purchasePrivacy/')
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
    public function itCanPurchaseDomainPrivacyWithMinimumData()
    {
        $domainName = $this->faker->domainName;
        $jsonResponse = $this->responseWithDomain($domainName);

        $service = $this->setupServiceWithResponse($jsonResponse);
        $response = $service->purchasePrivacy(new PurchaseRequest($domainName));

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertSame($domainName, $jsonResponse['domain']['domainName']);
    }

    /**
     * @test
     */
    public function itCanPurchaseDomainPrivacyWithAllRequestData()
    {
        $domainName = $this->faker->domainName;
        $jsonResponse = $this->responseWithDomain($domainName);

        $service = $this->setupServiceWithResponse($jsonResponse);
        $request = new PurchaseRequest($domainName);
        $request->setPurchasePrice('14.99');
        $request->setPurchaseYears(2);
        $response = $service->purchasePrivacy($request);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertSame($domainName, $jsonResponse['domain']['domainName']);
    }
}
