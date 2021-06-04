<?php

namespace Pleets\Tests\Unit\Domains;

use Pleets\NameCom\Domains\Constants\ContactType;
use Pleets\NameCom\Domains\ContactSet;
use Pleets\Tests\Feature\Concerns\HasContactInfo;
use Pleets\Tests\TestCase;

class ContactSetTest extends TestCase
{
    use HasContactInfo;

    /**
     * @test
     */
    public function itGeneratesAnEmptyArrayWithNotData()
    {
        $contactSet = new ContactSet();

        $this->assertSame([], $contactSet->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithContacts()
    {
        $contact = $this->createContact();

        $contactSet = new ContactSet();
        $contactSet->setContact($contact, ContactType::ADMIN);

        $this->assertSame([
            ContactType::ADMIN => $contact->toArray()
        ], $contactSet->toArray());
    }
}
