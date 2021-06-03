<?php

namespace Pleets\Tests\Unit\Domains;

use Pleets\NameCom\Domains\Requests\CreateDomainRequest;
use Pleets\Tests\TestCase;

class CreateDomainRequestTest extends TestCase
{
    /**
     * @test
     */
    public function itCreatesRequestsWithMinimumData()
    {
        $domain = $this->faker->domainName;

        $request = new CreateDomainRequest($domain);

        $this->assertSame([
            'domain' => [
                'domainName' => $domain
            ]
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function itCreatesRequestsWithPurchasePrice()
    {
        $domain = $this->faker->domainName;

        $request = new CreateDomainRequest($domain, '9.99');

        $this->assertSame([
            'domain' => [
                'domainName' => $domain
            ],
            'purchasePrice' => '9.99'
        ], $request->toArray());
    }
}
