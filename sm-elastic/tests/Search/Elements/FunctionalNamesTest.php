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
use SphereMall\Elastic\Search\Elements\FunctionalName;

class FunctionalNamesTest extends \PHPUnit\Framework\TestCase
{
    public function testConfigurationAvailable()
    {
        $json = file_get_contents(__DIR__ . '/../../../src/configs/search/functionalName.json');

        $testArray[] = json_decode(str_replace("__VALUE__", 254, $json), true);
        $testArray[] = json_decode(str_replace("__VALUE__", 12, $json), true);

        $functionalName = new FunctionalName('254,12');
        try {
            $attrArray = $functionalName->getQueryParams();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->assertEquals($testArray, $attrArray);
    }
}