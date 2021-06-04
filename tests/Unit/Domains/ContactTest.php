<?php

namespace Pleets\Tests\Unit\Domains;

use Pleets\NameCom\Domains\Contact;
use Pleets\Tests\TestCase;

class ContactTest extends TestCase
{
    /**
     * @test
     */
    public function itGeneratesAnEmptyArrayWithNotData()
    {
        $contact = new Contact();

        $this->assertSame([], $contact->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithAllData()
    {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $companyName = $this->faker->name;
        $address1 = $this->faker->address;
        $address2 = $this->faker->address;
        $city = $this->faker->city;
        $state = $this->faker->state;
        $zip = $this->faker->postcode;
        $countryCode = $this->faker->countryCode;
        $phone = $this->faker->phoneNumber;
        $fax = $this->faker->phoneNumber;
        $email = $this->faker->email;

        $contact = new Contact();
        $contact->setFirstName($firstName);
        $contact->setLastName($lastName);
        $contact->setCompanyName($companyName);
        $contact->setAddress1($address1);
        $contact->setAddress2($address2);
        $contact->setCity($city);
        $contact->setState($state);
        $contact->setZip($zip);
        $contact->setCountry($countryCode);
        $contact->setPhone($phone);
        $contact->setFax($fax);
        $contact->setEmail($email);

        $this->assertSame([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'companyName' => $companyName,
            'address1' => $address1,
            'address2' => $address2,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'country' => $countryCode,
            'phone' => $phone,
            'fax' => $fax,
            'email' => $email
        ], $contact->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $companyName = $this->faker->name;
        $address1 = $this->faker->address;
        $address2 = $this->faker->address;
        $city = $this->faker->city;
        $state = $this->faker->state;
        $zip = $this->faker->postcode;
        $countryCode = $this->faker->countryCode;
        $phone = $this->faker->phoneNumber;
        $fax = $this->faker->phoneNumber;
        $email = $this->faker->email;

        $contact = new Contact();
        $contact->setFirstName($firstName);
        $contact->setLastName($lastName);
        $contact->setCompanyName($companyName);
        $contact->setAddress1($address1);
        $contact->setAddress2($address2);
        $contact->setCity($city);
        $contact->setState($state);
        $contact->setZip($zip);
        $contact->setCountry($countryCode);
        $contact->setPhone($phone);
        $contact->setFax($fax);
        $contact->setEmail($email);

        $this->assertSame($firstName, $contact->getFirstName());
        $this->assertSame($lastName, $contact->getLastName());
        $this->assertSame($companyName, $contact->getCompanyName());
        $this->assertSame($address1, $contact->getAddress1());
        $this->assertSame($address2, $contact->getAddress2());
        $this->assertSame($city, $contact->getCity());
        $this->assertSame($state, $contact->getState());
        $this->assertSame($zip, $contact->getZip());
        $this->assertSame($countryCode, $contact->getCountry());
        $this->assertSame($phone, $contact->getPhone());
        $this->assertSame($fax, $contact->getFax());
        $this->assertSame($email, $contact->getEmail());
    }
}
