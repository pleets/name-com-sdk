<?php

namespace Pleets\NameCom\Responses;

class PostResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return $this->response->getStatusCode() === 200;
    }
}
