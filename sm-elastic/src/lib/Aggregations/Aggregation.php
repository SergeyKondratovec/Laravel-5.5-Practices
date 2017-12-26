<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 12/24/2017
 * Time: 2:26 PM
 */

namespace SphereMall\Elastic\Aggregations;

use SphereMall\Elastic\Aggregations\Elements\Attribute;
use SphereMall\Elastic\Aggregations\Elements\FunctionalName;
use SphereMall\Elastic\Search\SearchQuery;

class Aggregation
{
    protected $elements;
    protected $searchQuery;

    /**
     * Aggregation constructor.
     * @param SearchQuery $searchQuery
     * @param \SphereMall\MS\Entities\Attribute[] $attributes
     */
    public function __construct(SearchQuery $searchQuery, $attributes = [])
    {
        $this->searchQuery = $searchQuery;
        $this->setElement(new FunctionalName("functionalName"));
        if ($attributes) {
            foreach ($attributes as $attribute) {
                $this->setElement(new Attribute($attribute->id . "_attr"));
            }
        }
    }

    public function setElement($element)
    {
        $this->elements[] = $element;
    }

    public function get()
    {
        $params = [
            'index' => 'sm-*',
            'body'  => ['size' => 0],
        ];

        if ($query = $this->searchQuery->getQuery()) {
            $params['body']['query']['bool'] = $query;
        }

        if (empty($this->elements)) {
            return $params;
        }

        $params['body']['aggs'] = [];
        foreach ($this->elements as $element) {
            $params['body']['aggs'] = array_merge($params['body']['aggs'], $element->getField($this->searchQuery));
        }

        return $params;
    }

    public function getActiveFilter()
    {
        $filters = null;
        if ($this->searchQuery->getFilterElements()) {
            $filters = [];
            foreach ($this->searchQuery->getFilterElements() as $filter) {
                $key = lcfirst((new \ReflectionClass($filter))->getShortName());
                if (!isset($filters[$key])) {
                    $filters[$key] = [];
                }
                $filters[$key] = array_merge($filters[$key], $filter->getValues());
            }
        }

        return $filters;
    }
}