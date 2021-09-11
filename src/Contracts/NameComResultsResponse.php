<?php

namespace Pleets\NameCom\Contracts;

use Pleets\NameCom\Collections\Collection;

interface NameComResultsResponse extends NameComResponse
{
    public function results(): Collection;
}
