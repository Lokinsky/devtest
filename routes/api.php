<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Towns;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/**
 * API Towns
 * ------------------------------------------------------------------------
 * #1 Getting Country
 * #2 Getting Regoin by @var country_id:int @return JSON
 * #3 Getting Cities in City by @var region_id:int @return JSON
 * #4 Getting paginate methods by @var region_id:int, @return JSON
 */
Route::get('/country', [Towns::class,'fetchCountries']);
Route::get('/region/{country_id}', [Towns::class,'fetchRegions']);
Route::get('/city/{region_id}', [Towns::class,'fetchCities']);
Route::get('/city/paginate/{region_id}', [Towns::class,'paginateCities']);