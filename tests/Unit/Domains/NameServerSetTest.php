<?php

namespace Pleets\Tests\Unit\Domains;

use Pleets\NameCom\Domains\NameServerSet;
use Pleets\Tests\TestCase;

class NameServerSetTest extends TestCase
{
    /**
     * @test
     */
    public function itCanAddNameServers()
    {
        $ns1 = 'ns1.' . $this->faker->domainName;
        $ns2 = 'ns2.' . $this->faker->domainName;

        $nameservers = new NameServerSet();
        $nameservers->addNameServer($ns1);
        $nameservers->addNameServer($ns2);

        $this->assertSame([
            $ns1,
            $ns2,
        ], $nameservers->toArray());
    }

    /**
     * @test
     */
    public function itCanRemoveANameServer()
    {
        $ns1 = 'ns1.' . $this->faker->domainName;
        $ns2 = 'ns2.' . $this->faker->domainName;

        $nameservers = new NameServerSet();
        $nameservers->addNameServer($ns1);
        $nameservers->addNameServer($ns2);
        $nameservers->removeNameServer($ns1);

        $this->assertSame([
            $ns2
        ], $nameservers->toArray());
    }
}
