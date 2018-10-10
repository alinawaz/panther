<?php
use PHPUnit\Framework\TestCase;

final class EntityEntityControllerTest extends TestCase
{

    private $entity_controller;

    public function setUp()
    {
        $this->entity_controller = new \Panther\Entity\EntityController;
    }

    public function testCanCreateEntity()
    {
        $this->assertInstanceOf(\Panther\Entity\EntityController::class, $this->entity_controller);        
    }

    public function testCanToJson()
    {
        $data = ['test' => '123'];
        $encoded = $this->entity_controller->toJson($data);
        $this->assertSame('{"test":"123"}', $encoded);
    }

}