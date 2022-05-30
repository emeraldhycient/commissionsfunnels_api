<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

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
Route::group(['middleware' => ['auth:sanctum']], function () {

    //logout
    Route::get('/logout', [AuthController::class, 'logout']);
    //create a products
    Route::post('/products/create',[ProductController::class, 'create']);
    //update a product
    Route::post('/products/update/{product_id}',[ProductController::class, 'updateProduct']);
   
    
    //delete a product
    Route::delete('/products/delete/{product_id}',[ProductController::class, 'deleteProduct']);

});

Route::get('/', function () {
    return response()->json([
        'success' => 'Welcome to the commissionsfunnels API',
    ], 200);
});

//create a user
Route::post("/createaccount", [AuthController::class, "createaccount"]);
//login
Route::post("/login", [AuthController::class, "login"]);

 //get a product by id
 Route::get('/products/{product_id}',[ProductController::class, 'getProductById']);
 //get all products
 Route::get('/products/all',[ProductController::class, 'getAllProducts']);
 //get all products by category
 Route::get('/products/category/{category}',[ProductController::class, 'getProductsByCategory']);
 //get all products by seller
 Route::get('/products/seller/{seller_id}',[ProductController::class, 'getProductBySeller']);
 //search products by almost all fields
 Route::get('/products/search/{search}',[ProductController::class, 'getProductsBySearch']);
 // search product by commission
 Route::get('/products/commission/{commission}',[ProductController::class, 'getProductsByCommission']);



// Route::post('/products/create',[ProductController::class, 'create']);