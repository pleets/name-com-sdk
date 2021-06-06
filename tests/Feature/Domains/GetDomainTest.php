<?php

namespace Pleets\Tests\Feature\Domains;

use EasyHttp\MockBuilder\HttpMock;
use Pleets\NameCom\NameComApi;
use Pleets\Tests\TestCaseWithMockAuthentication;

class GetDomainTest extends TestCaseWithMockAuthentication
{
    /**
     * @test
     */
    public function itCanGetDomainDetails()
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
}
