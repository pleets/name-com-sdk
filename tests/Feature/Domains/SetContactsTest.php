<?php

namespace Pleets\Tests\Feature\Domains;

use EasyHttp\MockBuilder\HttpMock;
use Pleets\NameCom\Domains\Constants\ContactType;
use Pleets\NameCom\Domains\Requests\SetContactsRequest;
use Pleets\NameCom\NameComApi;
use Pleets\Tests\Feature\Concerns\HasDomainModelResponses;
use Pleets\Tests\TestCaseWithMockAuthentication;

class SetContactsTest extends TestCaseWithMockAuthentication
{
    use HasDomainModelResponses;

    /**
     * @test
     */
    public function itSetsContacts()
    {
        $domainName = $this->faker->domainName;
        $contactSet = $this->createContactSet(ContactType::ADMIN);

        $jsonResponse = $this->buildDomainModelResponse();
        $jsonResponse['contacts'] = $contactSet->toArray();

        $this->builder
            ->when()
                ->methodIs('POST')
                ->pathMatch('/v4\/domains\/' . self::DOMAIN_REGEX . ':setContacts/')
            ->then()
                ->statusCode(200)
                ->json($jsonResponse);

        $service = new NameComApi($this->baseUri);
        $service->setCredentials($this->username, $this->password);
        $service->withHandler(new HttpMock($this->builder));

        $request = new SetContactsRequest($domainName, $contactSet);
        $request->setContactSet($contactSet);
        $response = $service->setContacts($request);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getResponse()->getStatusCode());
        $this->assertSame($jsonResponse, $response->toArray());
        $this->assertSame($contactSet->toArray(), $jsonResponse['contacts']);
    }
}
