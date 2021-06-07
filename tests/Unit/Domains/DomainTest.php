<?php

namespace Pleets\Tests\Unit\Domains;

use Pleets\NameCom\Domains\Constants\ContactType;
use Pleets\NameCom\Domains\Domain;
use Pleets\Tests\Feature\Concerns\HasContactInfo;
use Pleets\Tests\Feature\Concerns\HasNameServers;
use Pleets\Tests\TestCase;

class DomainTest extends TestCase
{
    use HasContactInfo;
    use HasNameServers;

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
        $nameServerSet = $this->generateNameServerSet();

        $domain = new Domain($domainName);
        $domain->setNameServerSet($nameServerSet);

        $this->assertSame([
            'domainName' => $domainName,
            'nameservers' => $nameServerSet->toArray(),
            'privacyEnabled' => false,
            'locked' => true,
            'autorenewEnabled' => true,
        ], $domain->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithContacts()
    {
        $domainName = $this->faker->domainName;

        $domain = new Domain($domainName);
        $contactSet = $this->createContactSet(ContactType::BILLING);
        $domain->setContactSet($contactSet);

        $this->assertSame([
            'domainName' => $domainName,
            'contacts' => $contactSet->toArray(),
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
        $nameServerSet = $this->generateNameServerSet();
        $domain->setNameServerSet($nameServerSet);
        $contactSet = $this->createContactSet(ContactType::REGISTRANT);
        $domain->setContactSet($contactSet);
        $domain->setPrivacyEnabled(true);
        $domain->setLocked(false);
        $domain->setAutoRenewed(false);

        $this->assertSame($domainName, $domain->getDomainName());
        $this->assertSame($nameServerSet, $domain->getNameServerSet());
        $this->assertSame($contactSet, $domain->getContactSet());
        $this->assertTrue($domain->isPrivacyEnabled());
        $this->assertFalse($domain->isLocked());
        $this->assertFalse($domain->isAutoRenewed());
    }
}
