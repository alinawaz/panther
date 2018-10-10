<?php
use PHPUnit\Framework\TestCase;

final class EntityCollectionTest extends TestCase
{

    private $collection;

    public function setUp()
    {
        $this->collection = new \Panther\Entity\Collection;
    }

    public function testCanCreateEntity()
    {
        $this->assertInstanceOf(\Panther\Entity\Collection::class, $this->collection);        
    }

    public function testCanPushPopAndCount()
    {
        // Creating new entity for class TestEntity
        $entity = new \Panther\Entity\Entity('test', new \Test\Entities\TestEntity);
        // Pushing to collection
        $this->collection->push($entity);
        // Collection count should be 1
        $this->assertSame(1, $this->collection->count());
        // Popping from collection to $popped
        $popped = $this->collection->pop();
        // Collection count should be 0
        $this->assertSame(0, $this->collection->count());
        // $popped should be instance of Entity
        $this->assertInstanceOf(\Panther\Entity\Entity::class, $popped);
        // $popped should contain a class as instance of TestEntity
        $this->assertInstanceOf(\Test\Entities\TestEntity::class, $popped->get());
    }

    public function testCanTraverse()
    {
        // Flushing collection for fresh start
        $this->collection->flush();
        $this->assertSame(0, $this->collection->count());

        // Creating & pushing 2 entities
        $entity1 = new \Panther\Entity\Entity('test1', new \Test\Entities\TestEntity);
        $this->collection->push($entity1);
        $entity2 = new \Panther\Entity\Entity('test2', new \Test\Entities\AnotherTestEntity);
        $this->collection->push($entity2);

        // Traversing entities
        $counter = 1;
        $this->collection->traverse(function(\Panther\Entity\Interfaces\EntityInterface $entity) use (&$counter) {
            $this->assertInstanceOf(\Panther\Entity\Entity::class, $entity);
            if($counter == 1)
            {
                $this->assertInstanceOf(\Test\Entities\TestEntity::class, $entity->get());
            }
            if($counter == 2)
            {
                $this->assertInstanceOf(\Test\Entities\AnotherTestEntity::class, $entity->get());
            }
            $counter++;
        });
        $this->assertSame(3, $counter);
    }

}