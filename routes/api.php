<?php

use Illuminate\Http\Request;
use App\Http\Services\ProductService;
use Illuminate\Support\Facades\Route;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */
$apiKey = "6gHm58vpXYa";

Route::get('/advertisements', function (Request $request) use ($apiKey) {
    if ( !request("api_key") || request("api_key") != $apiKey ) {
        return response()->json(['message' => 'App key not found'], 401);
    }
    $products = ProductService::get();
    return response()->json($products, 200,
        ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
});
