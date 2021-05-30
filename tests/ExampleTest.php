<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Pleets\NameCom\Calculator;

class ExampleTest extends TestCase
{
    /**
     * @test
     */
    public function itCanTestSomething()
    {
	new Calculator();
        $this->assertTrue(true);
    }
}
