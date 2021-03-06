<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DispatchersController;
use App\Http\Controllers\VendorController;

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

    //vendors api starts  

    //register as a dispatcher
    Route::post('/dispatchers/register',[DispatchersController::class, 'becomeVendor']);

    //update dispatcher
    Route::post('/dispatchers/update/{company_id}',[DispatchersController::class, 'updateDispatcher']);

    //delete dispatcher
    Route::delete('/dispatchers/delete/{company_id}',[DispatchersController::class, 'deleteDispatcher']);

    //become a vendor
    Route::post('/vendors/register',[VendorController::class, 'becomeVendor']);

    //update vendor
    Route::post('/vendors/update/{company_id}',[VendorController::class, 'updateVendor']);

    //delete vendor
    Route::delete('/vendors/delete/{company_id}',[VendorController::class, 'deleteVendor']);


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
 Route::get('/products',[ProductController::class, 'getAllProducts']);
 //get all products by category
 Route::get('/products/category/{category}',[ProductController::class, 'getProductsByCategory']);
 //get all products by seller
 Route::get('/products/seller/{seller_id}',[ProductController::class, 'getProductBySeller']);
 //search products by almost all fields
 Route::get('/products/search/{search}',[ProductController::class, 'getProductsBySearch']);
 // search product by commission
 Route::get('/products/commission/{commission}',[ProductController::class, 'getProductsByCommission']);

//get all dispatchers
Route::get('/dispatchers',[DispatchersController::class, 'getDispatchers']);

//get a single dispatchers
Route::get('/dispatchers/{company_id}',[DispatchersController::class, 'getDispatcher']);

//get dispatchers by state
Route::get('/dispatchers/state/{state}',[DispatchersController::class, 'getDispatchersByState']);

//Route::post('/dispatchers/register',[DispatchersController::class, 'becomeVendor']);

//get all vendors
Route::get('/vendors',[VendorController::class, 'getVendors']);

//get a single vendor
Route::get('/vendors/{company_id}',[VendorController::class, 'getVendor']);

 //get vendors by state
Route::get('/vendors/state/{state}',[VendorController::class, 'getVendorsByState']);

//get vendors getVendorOrders
Route::get('/vendors/orders/{company_id}',[VendorController::class, 'getVendorOrders']);

//get vendors sales
Route::get('/vendors/sales/{company_id}',[VendorController::class, 'getVendorSales']);

//get vendor orders 
Route::get('/vendors/orders/{company_id}',[VendorController::class, 'getVendorOrders']);

//get vendor payments
Route::get('/vendors/payments/{company_id}',[VendorController::class, 'getVendorPayments']);

//get vendor profile
Route::get('/vendors/profile/{company_id}',[VendorController::class, 'getVendorProfile']);