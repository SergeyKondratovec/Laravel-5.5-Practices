<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 12/24/2017
 * Time: 1:18 PM
 */

namespace SphereMall\Elastic\Search;

use SphereMall\Elastic\Search\Elements\SearchElement;

/**
 * Class SearchQuery
 * @package SphereMall\Elastic\Search
 * @property  SearchElement[] $must
 * @property  SearchElement[] $filters
 */
class SearchQuery
{
    protected $must;
    protected $filters;

    protected $limit;
    protected $offset;
    protected $params;

    public function __construct($params = [], $limit = 10, $offset = 0)
    {
        $this->params = $params;
        $this->limit = $limit;
        $this->offset = $offset;

        $this->parseParams();
    }

    public function addElement(SearchElement $element)
    {
        switch ($element->getType()) {
            case SearchElement::FILTER:
                $this->filters[] = $element;
                break;

            case SearchElement::MUST:
                $this->must[] = $element;
                break;
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function get()
    {
        $params = [
            'index' => 'sm-*',
            'body'  => [
                'from' => $this->offset,
                'size' => $this->limit,
            ],
        ];

        if ($query = $this->getQuery()) {
            $params['body']['query']['bool'] = $query;

            /* $params['body']['highlight'] = [
                "pre_tags"  => ["<b>"],
                "post_tags" => ["</b>"],
                "fields"    => ["title" => new \stdClass()],
            ];*/
        }

        if ($filters = $this->getFilters()) {
            foreach ($filters as $filter) {
                $params['body']['query']['bool']['filter'][]['bool']['should'] = $filter;
            }
        }

        return $params;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getQuery()
    {
        $query = [];
        if (empty($this->must)) {
            return $query;
        }

        foreach ($this->must as $must) {
            $query = array_merge($query, $must->getQueryParams());
        }

        return $query;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getFilters()
    {
        $filters = [];

        if ($this->filters) {
            foreach ($this->filters as $filter) {
                $filters[] = $filter->getQueryParams();
            }
        }

        return $filters;
    }

    public function getFilterElements()
    {
        return $this->filters;
    }

    private function parseParams()
    {
        foreach ($this->params as $key => $value) {
            if (!($class = $this->getElementClass($key))) {
                continue;
            }

            if (is_array($value)) {
                if($key == 'attribute') {
                    foreach ($value as $name => $val) {
                        $this->addElement(new $class($val, $name));
                    }
                    continue;
                }

                $this->addElement(new $class($value, $key));
                continue;
            }

            $this->addElement(new $class($value, $key));
        }
    }

    private function getElementClass($key)
    {
        $name = "SphereMall\\Elastic\\Search\\Elements\\" . ucfirst($key);
        if (class_exists($name)) {
            return $name;
        }

        return false;
    }
}