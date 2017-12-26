<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 12/24/2017
 * Time: 3:28 PM
 */

namespace SphereMall\Elastic\Aggregations\Elements;

class Attribute extends AggregatorElement
{
    public function __construct($name = "")
    {
        $this->field = "{$name}.valueId";
        parent::__construct($name);
    }
}