<?php

namespace Pleets\Tests\Unit\Collections;

use PHPUnit\Framework\TestCase;
use Pleets\NameCom\Collections\Collection;

class CollectionTest extends TestCase
{
    /**
     * @test
     */
    public function itReturnsAnEmptyArrayWithNotData()
    {
        $collection = new Collection();

        $this->assertSame([], $collection->all());
    }

    /**
     * @test
     */
    public function itReturnsInitializedItems()
    {
        $collection = new Collection(['foo' => 'bar']);

        $this->assertSame(['foo' => 'bar'], $collection->all());
    }

    /**
     * @test
     */
    public function itCanGetItems()
    {
        $collection = new Collection(['a', 'foo' => 'bar', 'baz']);

        $this->assertSame('a', $collection->get(0));
        $this->assertSame('bar', $collection->get('foo'));
        $this->assertSame('baz', $collection->get(1));
        $this->assertNull($collection->get(2));
        $this->assertNull($collection->get('z'));
    }

    /**
     * @test
     */
    public function itCanGetDefaultWhenTheKeyDoesNotExists()
    {
        $collection = new Collection(['a', 'foo' => 'bar', 'baz']);

        $this->assertSame('default', $collection->get(2, 'default'));
        $this->assertSame('value', $collection->get('z', 'value'));
    }

    /**
     * @test
     */
    public function itCanCheckIfItHasAnItem()
    {
        $collection = new Collection(['a', 'foo' => 'bar', 'baz']);

        $this->assertTrue($collection->has(0));
        $this->assertTrue($collection->has('foo'));
        $this->assertTrue($collection->has(1));
        $this->assertFalse($collection->has('bar'));
        $this->assertFalse($collection->has(2));
    }

    /**
     * @test
     */
    public function itCanPushItems()
    {
        $collection = new Collection();

        $collection->push('a');

        $this->assertSame(['a'], $collection->all());

        $collection->push(['foo' => 'bar'], 'baz');

        $this->assertSame(['a', ['foo' => 'bar'], 'baz'], $collection->all());
    }

    /**
     * @test
     */
    public function itCanForgetExistingItems()
    {
        $collection = new Collection(['a', 'foo' => 'bar', 'baz']);

        $collection->forget(0);

        $this->assertSame(['foo' => 'bar', 1 => 'baz'], $collection->all());

        $collection->forget('foo', 1);

        $this->assertSame([], $collection->all());
    }

    /**
     * @test
     */
    public function itCannotForgetNonExistingItems()
    {
        $items = ['a', 'foo' => 'bar', 'baz'];
        $collection = new Collection($items);

        $collection->forget(5);

        $this->assertSame($items, $collection->all());
    }

    /**
     * @test
     */
    public function itCanGetTheFirstItem()
    {
        $collection = new Collection(['a', 'foo' => 'bar', 'baz']);

        $this->assertSame('a', $collection->first());
    }

    /**
     * @test
     */
    public function itCanGetTheLastItem()
    {
        $collection = new Collection(['a', 'foo' => 'bar', 'baz']);

        $this->assertSame('baz', $collection->last());
    }

    /**
     * @test
     */
    public function itCanSearchValuesWithTypeChecking()
    {
        $collection = new Collection(['a', 'foo' => 'bar', 'baz', '1']);

        $this->assertSame(2, $collection->search('1', true));
        $this->assertFalse($collection->search(1, true));
        $this->assertSame('foo', $collection->search('bar'));
    }

    /**
     * @test
     */
    public function itCanSearchValuesWithoutTypeChecking()
    {
        $collection = new Collection(['a', 'foo' => 'bar', 'baz', '1']);

        $this->assertSame(2, $collection->search('1'));
        $this->assertSame(2, $collection->search(1));
        $this->assertSame('foo', $collection->search('bar'));
    }
}
