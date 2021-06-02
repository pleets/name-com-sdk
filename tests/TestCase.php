<?php

namespace Pleets\Tests;

use Faker\Factory;
use Faker\Generator;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected Generator $faker;

    public function setUp(): void
    {
        $this->faker = Factory::create();

        parent::setUp();
    }
}
