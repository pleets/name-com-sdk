<?php

namespace Pleets\NameCom\Contracts;

use EasyHttp\LayerContracts\Contracts\HttpClientResponse;

interface NameComResponse
{
    public function isSuccessful(): bool;
    public function getResponse(): HttpClientResponse;
    public function toArray(): array;
}
