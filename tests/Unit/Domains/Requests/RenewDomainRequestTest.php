<?php

namespace Pleets\Tests\Unit\Domains\Requests;

use Pleets\NameCom\Domains\Requests\PurchaseRequest;
use Pleets\Tests\TestCase;

class RenewDomainRequestTest extends TestCase
{
    /**
     * @test
     */
    public function itCreatesRequestsWithMinimumData()
    {
        $domainName = $this->faker->domainName;

        $request = new PurchaseRequest($domainName);

        $this->assertSame([
            'years' => 1
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function itCreatesRequestsWithAllData()
    {
        $domainName = $this->faker->domainName;

        $request = new PurchaseRequest($domainName);
        $request->setPurchasePrice('9.99');
        $request->setPurchaseYears(2);

        $this->assertSame([
            'purchasePrice' => '9.99',
            'years' => 2
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeRequestProperties()
    {
        $domainName = $this->faker->domainName;
        $price = (string) $this->faker->randomFloat(2);
        $years = $this->faker->randomDigitNot(0);

        $request = new PurchaseRequest($this->faker->domainName);
        $request->setDomainName($domainName);
        $request->setPurchasePrice($price);
        $request->setPurchaseYears($years);

        $this->assertSame($domainName, $request->getDomainName());
        $this->assertSame($price, $request->getPurchasePrice());
        $this->assertSame($years, $request->getPurchaseYears());

        $this->assertSame([
            'purchasePrice' => $price,
            'years' => $years
        ], $request->toArray());
    }
}
