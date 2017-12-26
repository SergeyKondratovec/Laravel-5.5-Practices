<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 12/23/2017
 * Time: 2:52 PM
 */

namespace SphereMall\Elastic\Helpers;

class IndexHelper
{
    public static function getAvailableIndexes()
    {
        return ['product', 'document'];
    }

    public static function isAvailableIndex($index)
    {
        return array_search($index, static::getAvailableIndexes());
    }
}