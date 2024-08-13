<?php

use App\Services\ElasticsearchService;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'test';
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('posts', App\Http\Controllers\PostController::class);

// Route::get('/test-elasticsearch', function (ElasticsearchService $elasticsearchService) {
//     $response = $elasticsearchService->search('test_index', '_doc', [
//         'query' => [
//             'match_all' => new stdClass()
//         ]
//     ]);

//     return response()->json($response);
// });

Route::get('/test-redis', function () {
    $redis = Redis::connection();
    $testArray = ["name"=>"Farhad", "Role"=>"Admin"];

    // Set a value
    // $redis->set('test_key', json_encode($testArray));
    // $redis->set('test', "abc");

    // Get the value
    // return 'set key';
    // $value = $redis->get('test');
    $value = $redis->get('test');
    dd($value);

    return $value;
});
