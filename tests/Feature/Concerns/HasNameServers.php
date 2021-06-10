<?php

namespace Pleets\Tests\Feature\Concerns;

use Pleets\NameCom\Domains\NameServerCollection;

trait HasNameServers
{
    protected function generateNameServerCollection(): NameServerCollection
    {
        $ns1 = 'ns1.' . $this->faker->domainName;
        $ns2 = 'ns2.' . $this->faker->domainName;
        $nameservers = new NameServerCollection();
        $nameservers->add($ns1);
        $nameservers->add($ns2);

        return $nameservers;
    }
}
