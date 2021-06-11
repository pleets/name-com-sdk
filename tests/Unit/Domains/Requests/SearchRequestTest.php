<?php

namespace Pleets\Tests\Unit\Domains\Requests;

use Pleets\NameCom\Domains\Domain;
use Pleets\NameCom\Domains\Requests\CreateDomainRequest;
use Pleets\NameCom\Domains\Requests\SearchRequest;
use Pleets\NameCom\Domains\TldCollection;
use Pleets\Tests\TestCase;

class SearchRequestTest extends TestCase
{
    /**
     * @test
     */
    public function itCreatesRequestsWithMinimumData()
    {
        $domainName = $this->faker->domainName;

        $request = new SearchRequest($domainName);

        $this->assertSame([
            'keyword' => $domainName,
            'timeout' => 1000
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function itCreatesRequestsWithTldFilter()
    {
        $domainName = $this->faker->domainName;

        $request = new SearchRequest($domainName);
        $tldFilter = new TldCollection();
        $tldFilter->add('com');
        $tldFilter->add('net');
        $request->setTldFilter($tldFilter);

        $this->assertSame([
            'keyword' => $domainName,
            'timeout' => 1000,
            'tldFilter' => ['com', 'net']
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function itCanChangeRequestProperties()
    {
        $domainName = $this->faker->domainName;
        $tldFilter = new TldCollection();
        $tldFilter->add('com');
        $tldFilter->add('net');

        $request = new SearchRequest($this->faker->domainName);
        $request->setKeyword($domainName);
        $request->setTimeout(5000);
        $request->setTldFilter($tldFilter);

        $this->assertSame($domainName, $request->getKeyword());
        $this->assertSame(5000, $request->getTimeout());
        $this->assertSame($tldFilter, $request->getTldFilter());

        $this->assertSame([
            'keyword' => $domainName,
            'timeout' => 5000,
            'tldFilter' => ['com', 'net']
        ], $request->toArray());
    }
}
