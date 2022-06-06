<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dispatcher;

class DispatchersController extends Controller
{
    public function becomeVendor(Request $request){

        //rember to verify payment receipt
        $user = User::where('user_id',$request->user_id)->first();
        $dispatcher = Dispatcher::where('user_id',$request->user_id)->first();

        if ($user && $user->is_dispatcher == 1 && $dispatcher ) {
                return response()->json([
                'status' => 'failed',
                'message' => 'please check seems you are already a dispatcher if not check if there was an issue with ur login session',]);
        }

        $validate = $request->validate([
                'company_name' => 'required|string|max:255',
                'company_address' => 'required|string|max:255',
                'company_phone' => 'required|string|max:255',
                'company_email' => 'required|string|max:255',
                'company_website' => 'required|string|max:255',
                'company_images' => 'required',
                'company_representative' => 'required|string|max:255',
                'company_representative_phone' => 'required|string|max:255',
                'delivery_fee' => 'required|string|max:255',
                'company_location' => 'required|string|max:255',
                'company_delivery_zone' => 'required|string|max:255',
                'user_id' => 'required',
        ]);

        $next_payment_date = strtotime('next month');
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

        $user->is_dispatcher = 1;
        $user->save();
        
        $dispatcher = Dispatcher::create([
            'company_id' => $validate['user_id'].uniqid(),
            'company_name' => $validate['company_name'],
            'company_address' => $validate['company_address'],
            'company_phone' => $validate['company_phone'],
            'company_email' => $validate['company_email'],
            'company_website' => $validate['company_website'],
            'company_images' => json_encode($images),
            'company_representative' => $validate['company_representative'],
            'company_representative_phone' => $validate['company_representative_phone'],
            'delivery_fee' => $validate['delivery_fee'],
            'company_location' => $validate['company_location'],
            'company_delivery_zone' => $validate['company_delivery_zone'],
            'user_id' => $validate['user_id'],
            'next_payment_date' => $next_payment_date,
        ]);

       $user->is_dispatcher = 1;
        $user->save();


        return response()->json([
            'status' => 'success',
            'message' => 'You are now a dispatcher',
            'dispatcher' => $dispatcher,
        ], 200);

    }

    public function updateDispatcher(Request $request,$company_id){

        $dispatcher = Dispatcher::where('company_id',$company_id)->first();

        if($dispatcher){
            $validate = $request->validate([
                'company_name' => 'required|string|max:255',
                'company_address' => 'required|string|max:255',
                'company_phone' => 'required|string|max:255',
                'company_email' => 'required|string|max:255',
                'company_website' => 'required|string|max:255',
                'company_images' => 'required',
                'company_representative' => 'required|string|max:255',
                'company_representative_phone' => 'required|string|max:255',
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

            $dispatcher->company_name = $validate['company_name'];
            $dispatcher->company_address = $validate['company_address'];
            $dispatcher->company_phone = $validate['company_phone'];
            $dispatcher->company_email = $validate['company_email'];
            $dispatcher->company_website = $validate['company_website'];
            $dispatcher->company_images = json_encode($images);
            $dispatcher->company_representative = $validate['company_representative'];
            $dispatcher->company_representative_phone = $validate['company_representative_phone'];
            $dispatcher->delivery_fee = $validate['delivery_fee'];
            $dispatcher->company_location = $validate['company_location'];
            $dispatcher->company_delivery_zone = $validate['company_delivery_zone'];
            $dispatcher->user_id = $validate['user_id'];
            $dispatcher->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Dispatcher updated',
                'dispatcher' => $dispatcher,
            ], 200);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'Dispatcher not found',
            ], 404);
        }

    }


    public function getDispatcher($companyid){
        $dispatcher = Dispatcher::where('company_id', $companyid)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Dispatcher found',
            'dispatcher' => $dispatcher,
        ], 200);
    }

    public function getDispatchers(){
        $dispatchers = Dispatcher::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Dispatchers found',
            'dispatchers' => $dispatchers,
        ], 200);
    }

    public function getDispatchersByState($state){
        $dispatchers = Dispatcher::where('company_location', $state)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Dispatchers found',
            'dispatchers' => $dispatchers,
        ], 200);
    }

    public function getDispatchersByZone($zone){
        $dispatchers = Dispatcher::where('company_delivery_zone', $zone)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Dispatchers found',
            'dispatchers' => $dispatchers,
        ], 200);
    }

    //delete dispatcher

    public function deleteDispatcher($company_id){
        $dispatcher = Dispatcher::where('company_id', $company_id)->first();
        if($dispatcher){
            $dispatcher->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Dispatcher deleted',
            ], 200);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'Dispatcher not found',
            ], 404);
        }
    }

}