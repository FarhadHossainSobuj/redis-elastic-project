<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\ElasticsearchService;

class PostController extends Controller
{
    protected $elasticsearchService;
    public function __construct(ElasticsearchService $elasticsearchService)
    {
        $this->elasticsearchService = $elasticsearchService;
    }
    public function index()
    {
        $params = [
            'index' => 'posts',
            'body' => [
                'query' => [
                    'match_all' => (object) []
                ]
            ]
        ];

        $posts = $this->elasticsearchService->search($params);
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

        // Index post in Elasticsearch
        $params = [
            'index' => 'posts',
            'id' => $post->id,
            'body' => $post->toArray()
        ];

        $this->elasticsearchService->index($params);

        return redirect()->route('posts.index');
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
