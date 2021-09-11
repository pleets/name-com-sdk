<?php

namespace Pleets\NameCom\Domains\Responses;

use Pleets\NameCom\Collections\Collection;
use Pleets\NameCom\Contracts\NameComResultsResponse;
use Pleets\NameCom\Domains\SearchResult;
use Pleets\NameCom\Responses\PostResponse;

class SearchResultResponse extends PostResponse implements NameComResultsResponse
{
    public function results(): Collection
    {
        $collection = new Collection();

        foreach ($this->toArray() as $result) {
            $collection->push(new SearchResult($result));
        }

        return $collection;
    }
}
