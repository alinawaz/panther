<?php
use PHPUnit\Framework\TestCase;

final class ImporterTest extends TestCase
{

    private $importer;

    public function setUp()
    {
        $this->importer = new \Panther\Core\Importer('router');
    }

    public function testCanCreateImporter()
    {
        $importer = new \Panther\Core\Importer('router');
        $this->assertInstanceOf(\Panther\Core\Importer::class, $importer);        
    }

    public function testCanImportFrom()
    {
        $router = $this->importer->from('router');
        $this->assertInstanceOf(\Panther\Router\Router::class, $router);
    }

}