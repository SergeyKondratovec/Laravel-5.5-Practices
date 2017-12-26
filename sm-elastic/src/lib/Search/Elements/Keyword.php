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
 * Class Keyword
 * @package SphereMall\Elastic\Search\Elements
 */
class Keyword extends SearchElement
{
    #region [Public methods]
    /**
     * @return string
     */
    public function getType()
    {
        return static::MUST;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getQueryParams()
    {
        if (!isset($this->values[0]) || empty($this->values[0])) {
            return [];
        }

        $filter = $this->getQueryParamsWithValues();

        return $filter;
    }
    #endregion
}