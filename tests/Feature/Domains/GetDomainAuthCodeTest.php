<?php

namespace Pleets\Tests\Feature\Domains;

use EasyHttp\MockBuilder\HttpMock;
use Pleets\NameCom\NameComApi;
use Pleets\Tests\TestCaseWithMockAuthentication;

class GetDomainAuthCodeTest extends TestCaseWithMockAuthentication
{
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
}
