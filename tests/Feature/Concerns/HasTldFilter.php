<?php

namespace Pleets\Tests\Feature\Concerns;

use Pleets\NameCom\Domains\TldCollection;

trait HasTldFilter
{
    protected function createTldFilter(...$tlds): TldCollection
    {
        $tldFilter = new TldCollection();

        foreach ($tlds as $tld) {
            $tldFilter->add($tld);
        }

        return $tldFilter;
    }
}
