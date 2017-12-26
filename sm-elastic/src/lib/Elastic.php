<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 12/23/2017
 * Time: 1:41 PM
 */

namespace SphereMall\Elastic;

use Elasticsearch\ClientBuilder;
use SphereMall\Elastic\Aggregations\Aggregation;
use SphereMall\Elastic\Indexes\Index;
use SphereMall\Elastic\Search\SearchQuery;

class Elastic
{
    protected $client;

    public function __construct()
    {
        $hosts = [
            [
                'host'   => '192.168.53.72',
                'port'   => '9200',
                'scheme' => 'http',
                'user'   => 'elastic',
                'pass'   => 'kibana',
            ],
        ];

        $this->client = ClientBuilder::create()
            ->setHosts($hosts)
            ->build();
    }

    /**
     * @param SearchQuery $searchQuery
     * @return array
     * @throws \Exception
     */
    public function search(SearchQuery $searchQuery)
    {
        $params = $searchQuery->get();
        return $this->client->search($params);
    }

    public function facets(Aggregation $aggregation)
    {
        $params = $aggregation->get();
        return $this->client->search($params);
    }

    public function mapping($index)
    {
        $instance = $this->makeIndexInstance($index);

        $this->client->indices()->create($instance->getMapping());
    }

    public function indexing($index)
    {
        $instance = $this->makeIndexInstance($index);

        $items = $instance->getData();

        $this->client->bulk($items);
    }

    public function delete($index)
    {
        $instance = $this->makeIndexInstance($index);

        $this->client->indices()->delete(['index' => $instance->getIndexName()]);
    }

    /**
     * @param $index
     * @return object|Index
     */
    private function makeIndexInstance($index)
    {
        $reflection = new \ReflectionClass("SphereMall\\Elastic\\Indexes\\" . ucfirst($index));
        return $reflection->newInstance();
    }
}