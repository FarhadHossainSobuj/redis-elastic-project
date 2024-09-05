<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\ElasticsearchService;
use Elastic\Elasticsearch\ClientBuilder;
use Elasticsearch;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
    protected $elasticsearchService;
    public function __construct(ElasticsearchService $elasticsearchService)
    {
        $this->elasticsearchService = $elasticsearchService;
    }
    public function index()
    {
        // $client = ClientBuilder::create()->build();
        // $params = ['index' => 'my_index'];
        // $response = $client->search($params);
        // print_r($response->asArray());
        // return 'ok';

        // $data = [
        //     'body' => [
        //         'testField' => 'abc'
        //     ],
        //     'index' => 'my_index',
        //     'type' => 'my_type',
        //     'id' => 'my_id',
        // ];
        // $params = [
        //     'index' => 'my_index',
        //     'id'    => 'my_id',
        //     'body'  => ['testField' => 'abc']
        // ];



        // $client = ClientBuilder::create()->build();

        // $response = $client->index($params);
        // dd($response->asArray());


        // $res = $client->index($data);

        // // $stats = $client->indices()->stats(['index' => 'my_index']);
        // $stats = $client->info();
        // dd((string) $stats->getBody());



        // $params = [
        //     'index' => 'posts',
        //     'type' => 'text',
        //     'body' => [
        //         'query' => [
        //             'match_all' => (object) []
        //         ]
        //     ]
        // ];

        // $posts = $this->elasticsearchService->search($params);
        // dd($posts);

        $posts = Post::all();
        // dd($posts);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // Store post in the database
        $post = Post::create($request->all());
        Redis::set("post_{$post->id}", $post, 60);

        // Index post in Elasticsearch
        $params = [
            'index' => 'posts',
            'id' => $post->id,
            'body' => $post->toArray()
        ];

        $response = $this->elasticsearchService->index($params);
        // dd($response);


        return redirect()->route('posts.index');
    }

    public function search(Request $request)
    {
        // dd($request->all());
        $query = $request->input('query');
        $posts = json_decode(Post::search2($query));
        // dd($posts);
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post->update($request->all());
        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }
}
