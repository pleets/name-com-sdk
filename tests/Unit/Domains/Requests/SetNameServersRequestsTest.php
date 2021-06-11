<?php

namespace Pleets\Tests\Unit\Domains\Requests;

use Pleets\NameCom\Domains\NameServerCollection;
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
        $nameservers = new NameServerCollection();
        $nameservers->add($ns1);
        $nameservers->add($ns2);

        $request = new SetNameServersRequest($domainName);
        $request->setNameServerCollection($nameservers);

        $this->assertSame([
            $ns1,
            $ns2
        ], $request->toArray());
    }
}
