<?php

namespace Pleets\Tests\Unit\Domains\Requests;

use Pleets\NameCom\Domains\DomainCollection;
use Pleets\NameCom\Domains\Requests\CheckAvailabilityRequest;
use Pleets\Tests\TestCase;

class CheckAvailabilityRequestTest extends TestCase
{
    /**
     * @test
     */
    public function itCreatesRequests()
    {
        $domainName1 = $this->faker->domainName;
        $domainName2 = $this->faker->domainName;

        $domainCollection = new DomainCollection();
        $domainCollection->add($domainName1);
        $domainCollection->add($domainName2);
        $request = new CheckAvailabilityRequest($domainCollection);

        $this->assertSame([
            'domainNames' => [$domainName1, $domainName2]
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeRequestProperties()
    {
        $domainName1 = $this->faker->domainName;
        $domainName2 = $this->faker->domainName;

        $domainCollection = new DomainCollection();
        $domainCollection->add($domainName1);
        $domainCollection->add($domainName2);

        $request = new CheckAvailabilityRequest(new DomainCollection());
        $request->setDomainCollection($domainCollection);

        $this->assertSame($domainCollection, $request->getDomainCollection());

        $this->assertSame([
            'domainNames' => [$domainName1, $domainName2],
        ], $request->toArray());
    }
}
