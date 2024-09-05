<?php

namespace App\Models;

use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body'];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            $client = ClientBuilder::create()->build();
            $params = [
                'index' => 'posts',
                'id'    => $model->id,
                'body'  => $model->toArray(),
            ];
            $client->index($params);
        });

        static::deleted(function ($model) {
            $client = ClientBuilder::create()->build();
            $params = [
                'index' => 'posts',
                'id'    => $model->id,
            ];
            $client->delete($params);
        });
    }

    public static function search($query)
    {
        $client = ClientBuilder::create()->build();
        $params = [
            'index' => 'posts',
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query'  => $query,
                        'fields' => ['title', 'body'],
                    ],
                ],
            ],
        ];

        $results = $client->search($params);
        return collect($results['hits']['hits'])->pluck('_source')->toJson();
    }

    public static function search2($query)
    {
        $cacheKey = 'search_' . md5($query);

        // Check if search results are in the cache
        return Cache::remember($cacheKey, 60, function () use ($query) {
            // If not in cache, perform Elasticsearch search
            $client = ClientBuilder::create()->build();
            $params = [
                'index' => 'posts',
                'body'  => [
                    'query' => [
                        'multi_match' => [
                            'query'  => $query,
                            'fields' => ['title', 'body'],
                        ],
                    ],
                ],
            ];

            $results = $client->search($params);

            // Collect and return the results
            return collect($results['hits']['hits'])->pluck('_source')->toJson();
        });
    }
}
