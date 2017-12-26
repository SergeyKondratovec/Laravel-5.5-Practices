<?php

namespace App\Http\Controllers;


use Illuminate\Pagination\LengthAwarePaginator;
use SphereMall\Elastic\Aggregations\Aggregation;
use SphereMall\Elastic\Elastic;
use SphereMall\Elastic\Search\SearchQuery;
use SphereMall\MS\Client;

class IndexController extends Controller
{
    public function __construct()
    {
        $msClient = new Client([
            //'gatewayUrl' => 'http://gateway-main.alpha.spheremall.net:8082',
            'gatewayUrl' => 'http://gateway-bc.alpha.spheremall.net:8089',
            //'clientId'   => 'api_demo_user',
            'clientId'   => 'store_direct_web_client',
            //'secretKey'  => 'demo_pass',
            'secretKey'  => 'HGkjhd2389ohkjHDSJKh29dhljHD90382hd',
        ]);

        $this->availableAttributes = $msClient->attributes()
            ->limit(100)
            ->filter(['useInFilter' => ['e' => 1]])
            ->all();
    }

    public function index()
    {
        $elastic = new Elastic();

        $searchQuery = new SearchQuery($this->getQueryParams());

        $result = $elastic->search($searchQuery);

        $aggregation = new Aggregation($searchQuery, $this->availableAttributes);
        $facets = $elastic->facets($aggregation);

        $paging = new LengthAwarePaginator(
            count($result['hits']['hits']),
            $result['hits']['total'],
            10
        );

        return view('pages.home', compact('result', 'facets', 'paging'));
    }

    public function search()
    {
        $page = request('page') ?? 1;

        $result = $this->getSearchResult($page);


        $paging = new LengthAwarePaginator(
            count($result['hits']['hits']),
            $result['hits']['total'],
            10,
            $page
        );

        $resultHtml = view('objects.records', compact('result', 'paging'))->render();

        return compact('resultHtml');
    }

    public function filter()
    {
        list($aggregation, $facets) = $this->getFacetsResult();

        $filter = $aggregation->getActiveFilter();
        $facetsHtml = view('objects.filter', compact('facets', 'filter'))->render();
        return compact('facetsHtml');
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getSearchResult($page): array
    {
        $elastic = new Elastic();

        $searchQuery = new SearchQuery($this->getQueryParams(), 10, ($page - 1) * 10);

        $result = $elastic->search($searchQuery);
        return $result;
    }

    /**
     * @return array
     */
    private function getFacetsResult(): array
    {
        $elastic = new Elastic();

        $searchQuery = new SearchQuery($this->getQueryParams());

        $aggregation = new Aggregation($searchQuery, $this->availableAttributes);
        $facets = $elastic->facets($aggregation);
        return [$aggregation, $facets];
    }

    private function getQueryParams()
    {
        $params = [];

        foreach (request()->all() as $key => $param) {
            if ($key == 'attribute') {
                foreach ($param as $at) {
                    $params['attribute'][$at['attrId']][] = $at['id'];
                }
                continue;
            }

            $params[$key] = $param;
        }

        return $params;
    }
}