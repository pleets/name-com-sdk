<?php

namespace Pleets\Tests\Unit\Domains\Requests;

use Pleets\NameCom\Domains\NameServerSet;
use Pleets\NameCom\Domains\Requests\SetNameServersRequest;
use Pleets\Tests\TestCase;

class SetNameServersRequestsTest extends TestCase
{
    /**
     * @test
     */
    public function itGeneratesAnEmptyArrayWithoutNameServers()
    {
        $domainName = $this->faker->domainName;

        $request = new SetNameServersRequest($domainName);

        $this->assertSame([], $request->toArray());
    }

    /**
     * @test
     */
    public function itGeneratesAnArrayWithNameServers()
    {
        $domainName = $this->faker->domainName;
        $ns1 = 'ns1.' . $this->faker->domainName;
        $ns2 = 'ns2.' . $this->faker->domainName;
        $nameservers = new NameServerSet();
        $nameservers->addNameServer($ns1)->addNameServer($ns2);

        $request = new SetNameServersRequest($domainName);
        $request->setNameServerSet($nameservers);

        $this->assertSame([
            $ns1,
            $ns2
        ], $request->toArray());
    }
}
