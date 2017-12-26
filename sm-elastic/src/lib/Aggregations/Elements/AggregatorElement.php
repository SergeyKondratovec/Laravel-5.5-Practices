<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 12/24/2017
 * Time: 3:32 PM
 */

namespace SphereMall\Elastic\Aggregations\Elements;

use SphereMall\Elastic\Search\SearchQuery;

abstract class AggregatorElement
{
    #region [Properties]
    protected $name;
    protected $field;
    #endregion

    #region [Constructor]
    public function __construct($name = "")
    {
        $this->name = $name;
    }
    #endregion

    #region [public methods]
    /**
     * @param SearchQuery $searchQuery
     * @return mixed
     * @throws \Exception
     */
    public function getField(SearchQuery $searchQuery)
    {
        if ($filters = $this->getQueryFilters($searchQuery)) {
            $item[$this->name]['filter']['bool']['must'] = $filters;
            $item[$this->name]['aggs']['value']['terms']["field"] = $this->field;

            return $item;
        }

        $fileName = $this->getConfigFileName();

        $json = file_get_contents($fileName);

        $json = str_replace("__NAME__", $this->name, $json);

        return json_decode($json, true);
    }
    #endregion

    #region [Abstract methods]
    #endregion

    #region [Protected methods]
    /**
     * @return string
     * @throws \Exception
     */
    protected function getConfigFileName(): string
    {
        $elementName = ucfirst((new \ReflectionClass(get_called_class()))->getShortName());
        $fileName = __DIR__ . "/../../../configs/aggregations/aggs/$elementName.json";
        if (!file_exists($fileName)) {
            throw new \Exception("JSON aggregation configuration file was not found for [{$elementName}]");
        }

        return $fileName;
    }

    protected function getQueryFilters(SearchQuery $searchQuery)
    {
        $aggFilters = [];
        if (!($filters = $searchQuery->getFilterElements())) {
            return $aggFilters;
        }

        foreach ($filters as $filter) {
            if ($filter->getName() != $this->name) {
                $aggFilters[]['terms'][$filter->getFieldName()] = $filter->getValues();
            }
        }

        return $aggFilters;
    }
    #endregion
}