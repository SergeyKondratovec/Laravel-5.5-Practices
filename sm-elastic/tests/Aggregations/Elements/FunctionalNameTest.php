<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 12/23/2017
 * Time: 3:16 PM
 */

namespace SphereMall\Elastic\Tests\Aggregations\Elements;

use SphereMall\Elastic\Aggregations\Elements\FunctionalName;

class FunctionalNameTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @throws \Exception
     */
    public function testConfigurationAggAvailable()
    {
        $json = file_get_contents(__DIR__ . '/../../../src/configs/aggregations/aggs/functionalName.json');

        $testArray = json_decode($json, true);
        $functionalName = new FunctionalName();
        try {
            $field = $functionalName->getField();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $this->assertEquals($testArray, $field);
    }
}