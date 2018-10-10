<?php
use PHPUnit\Framework\TestCase;

final class EntityEntityTest extends TestCase
{

    private $entity;

    public function setUp()
    {
        $this->entity = new \Panther\Entity\Entity('test', new \Test\Entities\TestEntity);
    }

    public function testCanCreateEntity()
    {
        $this->assertInstanceOf(\Panther\Entity\Entity::class, $this->entity);        
    }

    public function testCanGet()
    {
        $class = $this->entity->get();
        $this->assertInstanceOf(\Test\Entities\TestEntity::class, $class);
    }

}