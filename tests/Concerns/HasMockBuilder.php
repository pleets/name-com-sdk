<?php

namespace Pleets\Tests\Concerns;

use EasyHttp\MockBuilder\MockBuilder;

trait HasMockBuilder
{
    protected string $username = 'user-test';
    protected string $password = 'fb229991b131304b390f1a633148a3832044d2b4';

    protected MockBuilder $builder;

    protected function createBuilder()
    {
        $builder = new MockBuilder();

        $builder
            ->when()
                ->headerNotExist('Authorization')
            ->then()
                ->statusCode(401)
                ->json([
                    'message' => 'Unauthenticated'
                ]);

        $builder
            ->when()
                ->headerIsNot('Authorization', 'Basic ' . base64_encode($this->username . ':' . $this->password))
            ->then()
                ->statusCode(403)
                ->json([
                    'message' => 'Permission Denied'
                ]);

        $this->builder = $builder;
    }
}
