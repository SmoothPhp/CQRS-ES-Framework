<?php namespace SmoothPhp\Test\AggregateRoot;

use SmoothPhp\EventSourcing\Entity;
use SmoothPhp\EventSourcing\AggregateRoot;
use SmoothPhp\Contracts\EventSourcing\Event;

/**
 * Class EntityTest
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class EntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_applies_recursively()
    {
        $root = new FooAggregate;
        $entity = new FooEntity;

        $root->addChildEntity($entity);
        $mock = $this->getMock(BarEntity::class, ['handleRecursively']);
        $mock->expects($this->once())
             ->method('handleRecursively');

        $entity->addChildEntity($mock);

        $root->foo();
    }

    /**
     * @test
     * @expectedException \SmoothPhp\EventSourcing\Exception\AggregateRootAlreadyRegistered
     */
    public function one_aggregate_to_rule_them_to_bind_them()
    {
        $root1 = new FooAggregate;
        $root2 = new FooAggregate;
        $entity = new FooEntity;

        $root1->addChildEntity($entity);
        $root2->addChildEntity($entity);

        $root1->foo();
        $root2->foo();
    }

    /**
     * @test
     */
    public function it_applies_events_to_the_aggregate_root()
    {
        $agg = new FooAggregate;
        $entity = new FooEntity;
        $entity->registerAggregateRoot($agg);

        $entity->foo();

        $this->assertCount(1, $agg->getUncommittedEvents());
    }
}

class FooAggregate extends AggregateRoot
{
    private $children = [];

    public function addChildEntity(\SmoothPhp\Contracts\EventSourcing\Entity $entity)
    {
        $this->children[] = $entity;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function foo()
    {
        $this->apply(new BarEvent);
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return '1';
    }
}

class FooEntity extends Entity
{
    private $children = [];

    public function addChildEntity(\SmoothPhp\Contracts\EventSourcing\Entity $entity)
    {
        $this->children[] = $entity;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function foo()
    {
        $this->apply(new BarEvent);
    }

    /**
     * @return string
     */
    public function getEntityId()
    {
        return '2';
    }
}

class BarEntity extends Entity
{
    /**
     * @return string
     */
    public function getEntityId()
    {
        return '3';
    }
}

class BarEvent implements Event {}