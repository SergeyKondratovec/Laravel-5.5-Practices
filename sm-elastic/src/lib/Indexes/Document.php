<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 12/23/2017
 * Time: 2:47 PM
 */

namespace SphereMall\Elastic\Indexes;

use SphereMall\MS\Client;

class Document extends Index
{
    public function getProperties()
    {
        /*$mapping = [
            'title'            => [
                'type'     => 'text',
                'analyzer' => 'standard',
            ],
            'functionalNameId' => [
                'type' => 'integer',
            ],
            'attributes'       => [
                'type'       => 'nested',
                'properties' => [
                    "id"    => [
                        "type" => "integer",
                    ],
                    "code"  => [
                        "type" => "text",
                    ],
                    "value" => [
                        'type'       => 'nested',
                        'properties' => [
                            "id"          => [
                                "type" => "integer",
                            ],
                            "value"       => [
                                "type" => "text",
                            ],
                            "orderNumber" => [
                                "type" => "integer",
                            ],
                        ],
                    ],
                ],
            ],
        ];*/

        $mapping = [
            'title'            => [
                'type'     => 'text',
                'analyzer' => 'standard',
            ],
            'functionalNameId' => [
                'type' => 'integer',
            ],
        ];

        return $mapping;
    }

    public function getEntitiesFromService()
    {
        $documents = $this->msClient->documents()
            ->limit(100)
            ->withMeta()
            ->full();

        return $documents;
    }

    public function getItem($entity)
    {
        $item = [];
        if ($entity->attributes) {
            $item = $this->getAttributes($entity->attributes);
        }

        $item = array_merge($item, [
            'title'            => $entity->title,
            'functionalNameId' => $entity->functionalNameId,
        ]);

        return $item;
    }
}