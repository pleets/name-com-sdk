<?php

namespace Pleets\Tests\Feature\Concerns;

use Pleets\NameCom\Domains\NameServerSet;

trait HasNameServers
{
    protected function generateNameServerSet(): NameServerSet
    {
        $ns1 = 'ns1.' . $this->faker->domainName;
        $ns2 = 'ns2.' . $this->faker->domainName;
        $nameservers = new NameServerSet();
        $nameservers->addNameServer($ns1)->addNameServer($ns2);

        return $nameservers;
    }
}
