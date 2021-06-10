<?php

namespace Pleets\Tests\Unit\Collections;

use PHPUnit\Framework\TestCase;
use Pleets\NameCom\Collections\SingleCollection;

class SingleCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function itCanAddItems()
    {
        $collection = new SingleCollection();

        $addItem1 = $collection->add('item 1');
        $addItem2 = $collection->add('item 2');

        $this->assertTrue($addItem1);
        $this->assertTrue($addItem2);
        $this->assertSame([
            'item 1',
            'item 2'
        ], $collection->toArray());
    }

    /**
     * @test
     */
    public function itCannotAddTheSameItemTwice()
    {
        $collection = new SingleCollection();

        $addItem1 = $collection->add('item 1');
        $addItem2 = $collection->add('item 1');

        $this->assertTrue($addItem1);
        $this->assertFalse($addItem2);
        $this->assertSame([
            'item 1',
        ], $collection->toArray());
    }

    /**
     * @test
     */
    public function itCanRemoveItems()
    {
        $collection = new SingleCollection();

        $collection->add('item 1');
        $collection->add('item 2');
        $removeItem = $collection->remove('item 1');

        $this->assertTrue($removeItem);
        $this->assertSame([
            'item 2'
        ], $collection->toArray());
    }

    /**
     * @test
     */
    public function itCannotRemoveANonExistingItem()
    {
        $collection = new SingleCollection();

        $collection->add('item 1');
        $collection->add('item 2');
        $removeItem = $collection->remove('item 3');

        $this->assertFalse($removeItem);
        $this->assertSame([
            'item 1',
            'item 2'
        ], $collection->toArray());
    }
}
