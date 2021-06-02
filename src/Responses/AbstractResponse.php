<?php

namespace Pleets\NameCom\Responses;

use EasyHttp\LayerContracts\Contracts\HttpClientResponse;
use EasyHttp\LayerContracts\Exceptions\ImpossibleToParseJsonException;
use Pleets\NameCom\Contracts\NameComResponse;

abstract class AbstractResponse implements NameComResponse
{
    protected HttpClientResponse $response;

    public function __construct(HttpClientResponse $response)
    {
        $this->response = $response;
    }

    public function getResponse(): HttpClientResponse
    {
        return $this->response;
    }

    public function toArray(): array
    {
        try {
            return $this->response->parseJson();
        } catch (ImpossibleToParseJsonException $e) {
            return [];
        }
    }
}
