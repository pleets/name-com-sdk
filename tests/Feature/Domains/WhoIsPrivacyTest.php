<?php

namespace Pleets\Tests\Feature\Domains;

use EasyHttp\MockBuilder\HttpMock;
use Pleets\NameCom\NameComApi;
use Pleets\Tests\Feature\Concerns\HasDomainModelResponses;
use Pleets\Tests\TestCaseWithMockAuthentication;

class WhoIsPrivacyTest extends TestCaseWithMockAuthentication
{
    use HasDomainModelResponses;

    /**
     * @test
     */
    public function itCanEnableWhoIsPrivacy()
    {
        $jsonResponse = array_replace_recursive($this->buildDomainModelResponse(), [
            'privacyEnabled' => true
        ]);

        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . ':enableWhoisPrivacy/')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->enableWhoIsPrivacy('test-domain.org');

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertTrue($jsonResponse['privacyEnabled']);
    }

    /**
     * @test
     */
    public function itCanDisableWhoIsPrivacy()
    {
        $jsonResponse = array_replace_recursive($this->buildDomainModelResponse(), [
            'privacyEnabled' => false
        ]);

        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . ':disableWhoisPrivacy/')
            ->then()
            ->statusCode(200)
            ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->disableWhoIsPrivacy('test-domain.org');

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertFalse($jsonResponse['privacyEnabled']);
    }
}
