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
 * Class FunctionalName
 * @package SphereMall\Elastic\Search\Elements
 */
class FunctionalName extends SearchElement
{
    protected $fieldName = "functionalNameId";

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