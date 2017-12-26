<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 12/23/2017
 * Time: 3:16 PM
 */
namespace SphereMall\Elastic\Tests;

class ElasticTest extends \PHPUnit\Framework\TestCase
{
    public function testProductIndexMapping()
    {
        $productIndex = new \SphereMall\Elastic\Indexes\Product();

        $this->assertNotEmpty($productIndex->getMapping());
    }
}