<?php

namespace Pleets\Tests\Unit\Domains\Requests;

use Pleets\NameCom\Domains\Constants\ContactType;
use Pleets\NameCom\Domains\ContactSet;
use Pleets\NameCom\Domains\Requests\SetContactsRequest;
use Pleets\Tests\Feature\Concerns\HasContactInfo;
use Pleets\Tests\TestCase;

class SetContactSetRequestTest extends TestCase
{
    use HasContactInfo;

    /**
     * @test
     */
    public function itCreatesAnEmptyArrayWithoutContacts()
    {
        $domainName = $this->faker->domainName;
        $contactSet = new ContactSet();

        $request = new SetContactsRequest($domainName, $contactSet);

        $this->assertSame([
            'contacts' => []
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function itCreatesRequestsWithSomeContact()
    {
        $domainName = $this->faker->domainName;
        $contactSet = new ContactSet();
        $contact = $this->createContact();
        $contactSet->setContact($contact, ContactType::ADMIN);

        $request = new SetContactsRequest($domainName, $contactSet);

        $this->assertSame([
            'contacts' => [
                ContactType::ADMIN => $contact->toArray()
            ]
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeRequestProperties()
    {
        $domainName = $this->faker->domainName;
        $contactSet = new ContactSet();
        $contact = $this->createContact();
        $contactSet->setContact($contact, ContactType::ADMIN);

        $request = new SetContactsRequest($this->faker->domainName, new ContactSet());
        $request->setDomainName($domainName);
        $request->setContactSet($contactSet);

        $this->assertSame($domainName, $request->getDomainName());
        $this->assertSame($contactSet, $request->getContactSet());

        $this->assertSame([
            'contacts' => [
                ContactType::ADMIN => $contact->toArray()
            ]
        ], $request->toArray());
    }
}
