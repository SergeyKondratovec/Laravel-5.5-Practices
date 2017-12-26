<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 12/23/2017
 * Time: 3:16 PM
 */

namespace SphereMall\Elastic\Tests\Search\Elements;

use Mockery\Exception;
use SphereMall\Elastic\Search\Elements\Attribute;

class AttributesTest extends \PHPUnit\Framework\TestCase
{
    public function testConfigurationAvailable()
    {
        $json = file_get_contents(__DIR__ . '/../../../src/configs/search/attribute.json');

        $testArray[] = json_decode(str_replace("__VALUE__", 10, $json), true);
        $testArray[] = json_decode(str_replace("__VALUE__", 20, $json), true);

        $attributeElement = new Attribute('10,20');
        try {
            $attrArray = $attributeElement->getQueryParams();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->assertEquals($testArray, $attrArray);
    }
}