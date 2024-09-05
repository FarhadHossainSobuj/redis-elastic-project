<?php

namespace App\Services;

use Elastic\Elasticsearch\ClientBuilder;


class ElasticsearchService
{
    protected $client;

    public function __construct()
    {

        $this->client = ClientBuilder::create()
            ->setHosts(['http://localhost:9200'])
            ->build();
    }

    public function search($params)
    {
        return $this->client->search([
            'index' => $params['index'],
            'type' => $params['type'],
            'body' => $params['body']
        ]);
    }

    public function index($params)
    {
        return $this->client->index($params);
    }
}
