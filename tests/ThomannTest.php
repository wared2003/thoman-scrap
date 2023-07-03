<?php
use Wared2003\ThomannScrap\Thomann;
use PHPUnit\Framework\TestCase;

class ThomannTest extends TestCase
{
    public function testGetCategorys()
    {
        $thomann = new Thomann('fr');
        $this->assertIsArray($thomann->getCategorys());
        $this->assertNotEmpty($thomann->getCategorys());
        $this->assertContainsOnlyInstancesOf(\Wared2003\ThomannScrap\models\Category::class, $thomann->getCategorys());
    }
}
