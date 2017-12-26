<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 12/23/2017
 * Time: 4:02 PM
 */

namespace SphereMall\Elastic\Indexes;

use SphereMall\MS\Client;
use SphereMall\MS\Entities\Attribute;

abstract class Index
{
    protected $msClient;

    public function __construct()
    {
        $_SERVER['SERVER_NAME'] = "TEST";

        $this->msClient = new Client([
            //'gatewayUrl' => 'http://gateway-main.alpha.spheremall.net:8082',
            'gatewayUrl' => 'http://gateway-bc.alpha.spheremall.net:8089',
            //'clientId'   => 'api_demo_user',
            'clientId'   => 'store_direct_web_client',
            //'secretKey'  => 'demo_pass',
            'secretKey'  => 'HGkjhd2389ohkjHDSJKh29dhljHD90382hd',
        ]);
    }

    public function getMapping()
    {
        $index = $this->getIndexName();
        $type = $this->getIndexType();

        return [
            'index' => $index,
            'body'  => [
                'mappings' => [
                    $type => [
                        'properties'        => $this->getProperties(),
                        'dynamic_templates' => [
                            [
                                'attributes' => [
                                    "match"   => "*_attr",
                                    "mapping" => [
                                        'properties' => [
                                            "id"      => [
                                                "type" => "integer",
                                            ],
                                            "valueId" => [
                                                "type" => "integer",
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }


    public function getIndexName()
    {
        return "sm-" . $this->getIndexType();
    }

    public function getIndexType()
    {
        return strtolower((new \ReflectionClass(get_called_class()))->getShortName());
    }

    public function getData()
    {


        $entities = $this->getEntitiesFromService();

        $items = [];
        foreach ($entities as $entity) {
            $items['body'][] = [
                'index' => [
                    '_index' => $this->getIndexName(),
                    '_type'  => $this->getIndexType(),
                    '_id'    => $entity->id,
                ],
            ];

            $items['body'][] = $this->getItem($entity);
        }

        return $items;
    }

    protected function getAttributes(array $attributes)
    {
        $return = [];
        /**
         * @var Attribute $attribute
         */
        foreach ($attributes as $attribute) {
            if (!$attribute->code) {
                continue;
            }
            /*foreach ($attribute->values as $value) {
                $return[] = [
                    'id'    => $attribute->id,
                    'code'  => $attribute->code,
                    'value' => [
                        'id'          => $value->id,
                        'value'       => $value->value,
                        'orderNumber' => $value->orderNumber,
                    ],
                ];
            }*/

            foreach ($attribute->values as $value) {
                $return[$attribute->id . '_attr'][] = [
                    'id'      => $attribute->id,
                    'valueId' => $value->id,
                ];
            }
        }

        return $return;
    }

    #region [Abstract methods]
    abstract function getProperties();

    abstract function getItem($entity);

    abstract function getEntitiesFromService();
    #endregion
}