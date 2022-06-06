<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;

class VendorController extends Controller
{
    //become a vendor

    public function becomeVendor(Request $request){

        //rember to verify payment receipt
        
        $user = User::where('user_id',$request->user_id)->first();
        $vendor = Vendor::where('user_id',$request->user_id)->first();

        if ($user && $user->is_vendor == 1 && $vendor) {
                return response()->json([
                'status' => 'failed',
                'message' => 'please check You are already a vendor if not check if there was an issue with ur login session',]);
        }

        $validate = $request->validate([
                'company_name' => 'required|string|max:255',
                'company_address' => 'required|string|max:255',
                'company_phone' => 'required|string|max:255',
                'company_email' => 'required|string|max:255',
                'company_website' => 'required|string|max:255',
                'company_images' => 'required',
                'company_location' => 'required|string|max:255',
                'company_delivery_zone' => 'required|string|max:255',
                'user_id' => 'required',
        ]);

        $next_payment_date = strtotime('next year');
        $next_payment_date = date('Y-m-d', $next_payment_date);

        $images = [];

        if ($request->hasFile('company_images')) {
            foreach ($request->file('company_images') as $key => $image) {
                $name = time().uniqid().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $image->move($destinationPath, $name);
                $images[$key]['path'] = "images/".$name;
            }
        }

        $user->is_vendor = 1;

        $user->save();

        $vendor = Vendor::create([
            'company_id' => $validate['user_id'].uniqid(),
            'company_name' => $validate['company_name'],
            'company_address' => $validate['company_address'],
            'company_phone' => $validate['company_phone'],
            'company_email' => $validate['company_email'],
            'company_website' => $validate['company_website'],
            'company_images' => json_encode($images),
            'company_location' => $validate['company_location'],
            'company_delivery_zone' => $validate['company_delivery_zone'],
            'user_id' => $validate['user_id'],
            'next_payment_date' => $next_payment_date,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'you are now a vendor'
        ]);
            
    }

    //update a vendor

    public function updateVendor(Request $request){
        $validate = $request->validate([
                'company_name' => 'required|string|max:255',
                'company_address' => 'required|string|max:255',
                'company_phone' => 'required|string|max:255',
                'company_email' => 'required|string|max:255',
                'company_website' => 'required|string|max:255',
                'company_images' => 'required',
                'delivery_fee' => 'required|string|max:255',
                'company_location' => 'required|string|max:255',
                'company_delivery_zone' => 'required|string|max:255',
                'user_id' => 'required',
        ]);

        $images = [];

        if ($request->hasFile('company_images')) {
            foreach ($request->file('company_images') as $key => $image) {
                $name = time().uniqid().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $image->move($destinationPath, $name);
                $images[$key]['path'] = "images/".$name;
            }
        }

        $vendor = Vendor::where('user_id', $request->user_id)->first();

        $vendor->company_name = $validate['company_name'];
        $vendor->company_address = $validate['company_address'];
        $vendor->company_phone = $validate['company_phone'];
        $vendor->company_email = $validate['company_email'];
        $vendor->company_website = $validate['company_website'];
        $vendor->company_images = json_encode($images);
        $vendor->company_location = $validate['company_location'];
        $vendor->company_delivery_zone = $validate['company_delivery_zone'];
    
        $vendor->save();

        return response()->json([
            'status' => 'success',
            'message' => 'you have updated your vendor profile'
        ]);
    }

    //get vendor profile

    public function getVendorProfile(Request $request){
        $vendor = Vendor::where('user_id', $request->user_id)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'you have updated your vendor profile',
            'data' => $vendor
        ]);
    }

    //get vendor orders

    public function getVendorOrders(Request $request){
        $vendor = Vendor::where('user_id', $request->user_id)->first();

        //remember to get the orders from sales table

        return response()->json([
            'status' => 'success',
            'message' => 'you have updated your vendor profile',
            'orders' => '$orders'
        ]);
    }

    //get vendor sales

    public function getVendorSales(Request $request){
        $vendor = Vendor::where('user_id', $request->user_id)->first();

        //remember to get the orders from sales table

        return response()->json([
            'status' => 'success',
            'message' => 'you have updated your vendor profile',
            'sales' => '$sales'
        ]);
    }

    //get vendor payments

    public function getVendorPayments(Request $request){
        $vendor = Vendor::where('user_id', $request->user_id)->first();

        //remember to get the payments from sales table

        return response()->json([
            'status' => 'success',
            'message' => 'you have updated your vendor profile',
            'payments' => '$payments'
        ]);
    }

    //get vendors

    public function getVendors(Request $request){
        $vendors = Vendor::all();

        return response()->json([
            'status' => 'success',
            'message' => 'vendors found',
            'vendors' => $vendors
        ]);
    }

    //get a vendor

    public function getVendor(Request $request){
        $vendor = Vendor::where('company_id', $request->company_id)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'vendor found',
            'vendor' => $vendor
        ]);
    }

    // get vendor by state

    public function getVendorByState(Request $request){
        $vendors = Vendor::where('company_delivery_zone', $request->state)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'vendors found',
            'vendors' => $vendors
        ]);
    }

    //delete a vendor

    public function deleteVendor(Request $request){
        $vendor = Vendor::where('company_id', $request->company_id)->first();

        $vendor->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'vendor deleted'
        ]);
    }

    



}