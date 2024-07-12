<?php

namespace App\Services;

use Elastic\Elasticsearch\ClientBuilder;


class ElasticsearchService
{
    protected $client;

    public function __construct()
    {

        $this->client = ClientBuilder::create()
            ->setHosts([config('elasticsearch.hosts')])
            ->build();
    }

    public function search($index, $type, $body)
    {
        return $this->client->search([
            'index' => $index,
            'type' => $type,
            'body' => $body
        ]);
    }

    public function index($params)
    {
        return $this->client->index($params);
    }
}
