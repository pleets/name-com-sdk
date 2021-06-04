<?php

namespace Pleets\Tests\Unit\Domains;

use Pleets\NameCom\Domains\Constants\ContactType;
use Pleets\NameCom\Domains\Domain;
use Pleets\Tests\Feature\Concerns\HasContactInfo;
use Pleets\Tests\TestCase;

class DomainTest extends TestCase
{
    use HasContactInfo;

    /**
     * @test
     */
    public function itGeneratesAnArrayWithGivenDomainName()
    {
        $domainName = $this->faker->domainName;

        $domain = new Domain($domainName);

        $this->assertSame([
            'domainName' => $domainName,
            'privacyEnabled' => false,
            'locked' => true,
            'autorenewEnabled' => true,
        ], $domain->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithNameServers()
    {
        $domainName = $this->faker->domainName;

        $domain = new Domain($domainName);
        $domain->setNameservers(['ns1.example.org', 'ns2.example.org']);

        $this->assertSame([
            'domainName' => $domainName,
            'nameservers' => ['ns1.example.org', 'ns2.example.org'],
            'privacyEnabled' => false,
            'locked' => true,
            'autorenewEnabled' => true,
        ], $domain->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $domainName = $this->faker->domainName;
        $domain = new Domain($domainName);

        $this->assertSame($domainName, $domain->getDomainName());

        $domainName = $this->faker->domainName;
        $domain->setDomainName($domainName);
        $domain->setNameservers(['ns1.example.org', 'ns2.example.org']);
        $contactSet = $this->createContactSet(ContactType::REGISTRANT);
        $domain->setContactSet($contactSet);
        $domain->setPrivacyEnabled(true);
        $domain->setLocked(false);
        $domain->setAutorenew(false);

        $this->assertSame($domainName, $domain->getDomainName());
        $this->assertSame(['ns1.example.org', 'ns2.example.org'], $domain->getNameservers());
        $this->assertSame($contactSet, $domain->getContactSet());
        $this->assertTrue($domain->isPrivacyEnabled());
        $this->assertFalse($domain->isLocked());
        $this->assertFalse($domain->isAutorenew());
    }
}
