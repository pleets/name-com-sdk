<?php

namespace Pleets\NameCom\Domains\Requests;

use Pleets\NameCom\Domains\TldCollection;

class SearchRequest
{
    protected string $keyword;
    protected int $timeout = 1000;
    protected ?TldCollection $tldFilter = null;

    public function __construct(string $keyword)
    {
        $this->keyword = $keyword;
    }

    public function getKeyword(): string
    {
        return $this->keyword;
    }

    public function setKeyword(string $keyword): self
    {
        $this->keyword = $keyword;

        return $this;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function getTldFilter(): ?TldCollection
    {
        return $this->tldFilter;
    }

    public function setTldFilter(?TldCollection $tldFilter): self
    {
        $this->tldFilter = $tldFilter;

        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'keyword' => $this->keyword,
            'timeout' => $this->timeout,
        ];

        if ($this->tldFilter) {
            $data['tldFilter'] = $this->tldFilter->toArray();
        }

        return $data;
    }
}
