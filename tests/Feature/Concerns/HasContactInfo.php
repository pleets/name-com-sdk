<?php

namespace Pleets\Tests\Feature\Concerns;

use Pleets\NameCom\Domains\Contact;
use Pleets\NameCom\Domains\ContactSet;

trait HasContactInfo
{
    protected function generateContactInfo(): array
    {
        return [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'companyName' => $this->faker->address,
            'address1' => $this->faker->address,
            'address2' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => $this->faker->postcode,
            'country' => $this->faker->countryCode,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email
        ];
    }

    protected function createContact(): Contact
    {
        $contact = new Contact();
        $contact->setFirstName($this->faker->firstName);
        $contact->setLastName($this->faker->lastName);
        $contact->setCompanyName($this->faker->address);
        $contact->setAddress1($this->faker->address);
        $contact->setAddress2($this->faker->address);
        $contact->setCity($this->faker->city);
        $contact->setState($this->faker->state);
        $contact->setZip($this->faker->postcode);
        $contact->setCountry($this->faker->countryCode);
        $contact->setPhone($this->faker->phoneNumber);
        $contact->setEmail($this->faker->email);

        return $contact;
    }

    protected function createContactSet(string $type): ContactSet
    {
        $contactSet = new ContactSet();
        $contactSet->setContact($this->createContact(), $type);

        return $contactSet;
    }
}
