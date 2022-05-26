<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\CardsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// controller で ./にリダイレクトにした
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ./でログインしていなければ、ログイン画面に飛ばす

// リスト一覧 (リストの中に、カードがたくさんある)
Route::get('/', [App\Http\Controllers\ListingsController::class, 'index']); // ?
// リスト新規作成
Route::get('/new', [App\Http\Controllers\ListingsController::class, 'new'])->name('new'); 
// リスト新規登録
Route::post('/listings', [App\Http\Controllers\ListingsController::class, 'store']);// ?
// リスト更新画面
Route::get('/listingsedit/{listing_id}', [App\Http\Controllers\ListingsController::class, 'edit']); // ?
// リスト更新処理
Route::post('/listing/edit', [App\Http\Controllers\ListingsController::class, 'update']); // ?
// リスト削除処理
Route::get('/listingsdelete/{listing_id}', [App\Http\Controllers\ListingsController::class, 'destroy']); // ?



//===ここから下を追加=== 4-2
// カードはそれぞれのタスク
//カード新規画面
Route::get('listing/{listing_id}/card/new', [App\Http\Controllers\CardsController::class, 'new'])->name('new_card');

//カード新規処理
Route::post('/listing/{listing_id}/card', [CardsController::class, 'store']);

//カード詳細画面
Route::get('listing/{listing_id}/card/{card_id}', [CardsController::class, 'show']);

//カード編集画面
Route::get('listing/{listing_id}/card/{card_id}/edit', [CardsController::class, 'edit']);

//カード更新処理
Route::post('/card/edit', [CardsController::class, 'update']);

//カード削除処理
Route::get('listing/{listing_id}/card/{card_id}/delete', [CardsController::class, 'destroy']);