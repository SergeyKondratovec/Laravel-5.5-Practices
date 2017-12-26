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
use SphereMall\Elastic\Search\Elements\Keyword;

class KeywordTest extends \PHPUnit\Framework\TestCase
{
    public function testConfigurationAvailable()
    {
        $json = file_get_contents(__DIR__ . '/../../../src/configs/search/keyword.json');

        $testArray = json_decode(str_replace("__VALUE__", "test search", $json), true);

        $keyword = new Keyword('test search');
        try {
            $attrArray = $keyword->getQueryParams();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->assertEquals($testArray, $attrArray);
    }
}