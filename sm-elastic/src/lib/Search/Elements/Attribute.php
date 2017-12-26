<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 12/24/2017
 * Time: 2:28 PM
 */

namespace SphereMall\Elastic\Search\Elements;

/**
 * Class Attribute
 * @package SphereMall\Elastic\Search\Elements
 */
class Attribute extends SearchElement
{
    public function __construct($values, $name = "")
    {
        $this->fieldName = "{$name}.valueId";
        parent::__construct($values, $name);
    }

    #region [Public methods]

    /**
     * @return string
     */
    public function getType()
    {
        return static::FILTER;
    }
    #endregion
}