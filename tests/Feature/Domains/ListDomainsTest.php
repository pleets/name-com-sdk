<?php

namespace Pleets\Tests\Feature\Domains;

use EasyHttp\MockBuilder\HttpMock;
use Pleets\NameCom\NameComApi;
use Pleets\Tests\TestCaseWithMockAuthentication;

class ListDomainsTest extends TestCaseWithMockAuthentication
{
    /**
     * @test
     */
    public function itCanListDomains()
    {
        $jsonResponse = [
            'domains' => [
                'domainName' => 'example.com',
                'locked' => true,
                'autorenewEnabled' => true,
                'expireDate' => '2022-05-30T07:00:11Z',
                'createDate' => '2021-05-30T07:00:11Z'
            ]
        ];

        $this->builder
            ->when()
                ->methodIs('GET')
                ->pathIs('/v4/domains')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $response = $service->listDomains();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
    }
}
