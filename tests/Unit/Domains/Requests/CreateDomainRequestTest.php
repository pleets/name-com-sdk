<?php

namespace Pleets\Tests\Unit\Domains\Requests;

use Pleets\NameCom\Domains\Domain;
use Pleets\NameCom\Domains\Requests\CreateDomainRequest;
use Pleets\Tests\TestCase;

class CreateDomainRequestTest extends TestCase
{
    /**
     * @test
     */
    public function itCreatesRequestsWithMinimumData()
    {
        $domainName = $this->faker->domainName;

        $request = new CreateDomainRequest($domain = new Domain($domainName));

        $this->assertSame([
            'domain' => $domain->toArray(),
            'years' => 1
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function itCreatesRequestsWithAllData()
    {
        $domainName = $this->faker->domainName;

        $request = new CreateDomainRequest($domain = new Domain($domainName));
        $request->setPurchasePrice('9.99');
        $request->setPurchaseType('registration');
        $request->setPurchaseYears(2);

        $this->assertSame([
            'domain' => $domain->toArray(),
            'purchasePrice' => '9.99',
            'purchaseType' => 'registration',
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
        $type = $this->faker->word;
        $years = $this->faker->randomDigitNot(0);

        $request = new CreateDomainRequest(new Domain('example.org'));
        $request->setDomain($domain = new Domain($domainName));
        $request->setPurchasePrice($price);
        $request->setPurchaseType($type);
        $request->setPurchaseYears($years);

        $this->assertSame($domain, $request->getDomain());
        $this->assertSame($price, $request->getPurchasePrice());
        $this->assertSame($type, $request->getPurchaseType());
        $this->assertSame($years, $request->getPurchaseYears());

        $this->assertSame([
            'domain' => $domain->toArray(),
            'purchasePrice' => $price,
            'purchaseType' => $type,
            'years' => $years
        ], $request->toArray());
    }
}
