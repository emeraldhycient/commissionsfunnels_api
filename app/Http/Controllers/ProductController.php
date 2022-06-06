<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class ProductController extends Controller
{
    //

    public function create (Request $request)


    {
      $id =$request->product_seller; 
       $user = User::where('user_id',$id)->first();

       if($user && $user->is_dispatcher === 1){

            //validate incoming request
            $validate = $request->validate([
                'product_name' => 'required|string|max:255',
                'product_description' => 'required|string|max:255',
                'product_price' => 'required|string|max:255',
                'product_category' => 'required|string|max:255',
                'product_quantity' => 'required|string|max:255',
                'product_commission' => 'required|string|max:255',
                'product_seller' => 'required',
                'sales_copy' => 'required|string',
                'product_delivery' => 'required|string|max:255',
            ]);
    
             $imagepath = null;
            if($request->hasFile('product_image')){
                $image = $request->file('product_image');
                $name = time().uniqid().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $image->move($destinationPath, $name);
                $imagepath = "images/".$name;
            }else
            {
               return response()->json([
                'status' => 'failed',
                'message' => 'Image is required',]);
            }

            //create  a user
            $product = Product::create(
                [
                    'product_id' => $request->product_seller.uniqid(),
                    'product_name' => $validate['product_name'],
                    'product_description' => $validate['product_description'],
                    'product_price' => $validate['product_price'],
                    'product_image' => $imagepath,
                    'product_category' => $validate['product_category'],
                    'product_quantity' => $validate['product_quantity'],
                    'product_commission' => $validate['product_commission'],
                    'product_seller' => $validate['product_seller'],
                    'sales_copy' => $validate['sales_copy'],
                    'product_delivery' => $validate['product_delivery'],
                ]
            );
            //send a success  response  with status 200,user,token and message
            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully',
                'product' => $product,
            ], 200);
        }else
        {
            return response()->json([
                'status' => 'failed',
                'message' => 'You are not a vendor',
            ], 404);
        }
    }


    public function getProductById($id)
    {
        $product = Product::find($id);
        if(!$product){
            return response()->json([
                'status' => 'failed',
                'message' => 'Product does not exist',
                'product' => $product,
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Product retrieved successfully',
            'product' => $product,
        ], 200);
    }

    public function getAllProducts()
    {
        $products = Product::where('is_approved',1)->get();
        if(!$products){
            return response()->json([
                'status' => 'failed',
                'message' => 'an error occured we couldnt fetch any products',
                'products' => $products,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Products retrieved successfully',
            'products' => $products,
        ], 200);
    }

    public function updateProduct(Request $request, $id)
    {
        $validate = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string|max:255',
            'product_price' => 'required|string|max:255',
            'product_image' => 'required|string|max:255',
            'product_category' => 'required|string|max:255',
            'product_quantity' => 'required|string|max:255',
            'product_commission' => 'required|string|max:255',
            'product_seller' => 'required|string|max:255',
            'sales_copy' => 'required|string|max:255',
        ]);

        $product = Product::find($id);
        if(!$product){
            return response()->json([
                'status' => 'failed',
                'message' => 'Product does not exist',
                'product' => $product,
            ], 404);
        }

        $product->product_name = $validate['product_name'];
        $product->product_description = $validate['product_description'];
        $product->product_price = $validate['product_price'];
        $product->product_image = $validate['product_image'];
        $product->product_category = $validate['product_category'];
        $product->product_quantity = $validate['product_quantity'];
        $product->product_commission = $validate['product_commission'];
        $product->product_seller = $validate['product_seller'];
        $product->sales_copy = $validate['sales_copy'];
        $product->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'product' => $product,
        ], 200);
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if(!$product){
            return response()->json([
                'status' => 'failed',
                'message' => 'Product does not exist',
                'product' => $product,
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully',
            'product' => $product,
        ], 200);
    }

    public function getProductByCategory($category)
    {
        $products = Product::where('product_category', $category)->get();
        if(!$products){
            return response()->json([
                'status' => 'failed',
                'message' => 'Products does not exist',
                'products' => $products,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Products retrieved successfully',
            'products' => $products,
        ], 200);
    }

    public function getProductBySeller($seller)
    {
        $products = Product::where('product_seller', $seller)->get();
        if(!$products){
            return response()->json([
                'status' => 'failed',
                'message' => 'Products does not exist',
                'products' => $products,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Products retrieved successfully',
            'products' => $products,
        ], 200);
    }

   
  

    public function getProductByCommission($commission)
    {
        $products = Product::where('product_commission', $commission)->get();
        if(!$products){
            return response()->json([
                'status' => 'failed',
                'message' => 'Products does not exist',
                'products' => $products,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Products retrieved successfully',
            'products' => $products,
        ], 200);
    }

   
    public function getProductByName($name)
    {
        $products = Product::where('product_name', $name)->get();
        if(!$products){
            return response()->json([
                'status' => 'failed',
                'message' => 'Products does not exist',
                'products' => $products,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Products retrieved successfully',
            'products' => $products,
        ], 200);
    }

  

    public function searchProduct($search)
    {
        $products = Product::where('product_name', 'like', '%'.$search.'%')
        ->orWhere('product_description', 'like', '%'.$search.'%')
        ->orWhere('product_price', 'like', '%'.$search.'%')
        ->orWhere('product_category', 'like', '%'.$search.'%')
        ->orWhere('product_quantity', 'like', '%'.$search.'%')
        ->orWhere('product_commission', 'like', '%'.$search.'%')
        ->orWhere('product_seller', 'like', '%'.$search.'%')
        ->orWhere('sales_copy', 'like', '%'.$search.'%')
        ->get();
        if(!$products){
            return response()->json([
                'status' => 'failed',
                'message' => 'Products does not exist',
                'products' => $products,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Products retrieved successfully',
            'products' => $products,
        ], 200);
    }

}