<?php

namespace Pleets\Tests\Feature\Domains;

use EasyHttp\MockBuilder\HttpMock;
use Pleets\NameCom\NameComApi;
use Pleets\Tests\Feature\Concerns\HasDomainModelResponses;
use Pleets\Tests\TestCaseWithMockAuthentication;

class AutoRenewalTest extends TestCaseWithMockAuthentication
{
    use HasDomainModelResponses;

    /**
     * @test
     */
    public function itCanEnableAutoRenewal()
    {
        $jsonResponse = array_replace_recursive($this->buildDomainModelResponse(), [
            'autorenewEnabled' => true
        ]);

        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . ':enableAutorenew/')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->enableAutoRenewal('test-domain.org');

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertTrue($jsonResponse['autorenewEnabled']);
    }

    /**
     * @test
     */
    public function itCanDisableAutoRenewal()
    {
        $jsonResponse = array_replace_recursive($this->buildDomainModelResponse(), [
            'autorenewEnabled' => false
        ]);

        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . ':disableAutorenew/')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->disableAutoRenewal('test-domain.org');

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertFalse($jsonResponse['autorenewEnabled']);
    }
}
