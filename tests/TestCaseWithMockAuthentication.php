<?php

namespace Pleets\Tests;

use Pleets\Tests\Feature\Concerns\HasMockBuilder;
use Pleets\Tests\Feature\Concerns\HasResponses;

class TestCaseWithMockAuthentication extends TestCase
{
    use HasMockBuilder;
    use HasResponses;

    protected const DOMAIN_REGEX = '(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]';
    protected string $baseUri = 'https://api.dev.name.com';

    public function setUp(): void
    {
        $this->createBuilder();
        parent::setUp();
    }
}
