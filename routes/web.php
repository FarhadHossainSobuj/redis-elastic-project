<?php

use App\Http\Controllers\PostController;
use App\Services\ElasticsearchService;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('posts', App\Http\Controllers\PostController::class);
Route::get('post/search', [App\Http\Controllers\PostController::class, 'search'])->name('search.posts');

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

    // Set a value
    // $redis->set('test_key', 'Redis is working2!', 50);

    // Get the value
    $value = $redis->get('test_key');

    return $value;
});


Route::get('/transfer-money', [App\Http\Controllers\TransferMoneyController::class, 'transfer'])->name('transfer.view');

Route::post('/transfer-money', [App\Http\Controllers\TransferMoneyController::class, 'transferStore'])->name('tranfer-store');
