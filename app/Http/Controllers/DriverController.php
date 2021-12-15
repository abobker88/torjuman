<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Document;

class DriverController extends Controller
{
    

    public function driver_list(){
       
       $drivers = Driver::orderBy('id', 'desc')->get();

       $data = [
            'category_name' => 'datatable',
            'page_name' => 'drivers_page',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

       return view('driver.index', compact('drivers'))->with($data);

    }


    public function driver_del($id){

    	Driver::where('id', $id)->delete();

    	return redirect()->back()->with('success', 'Deleted Successfully!');

    }

    public function del_doc($id){

        Document::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Deleted Successfully!');

    }

    public function driver_edit($id){

    	$driver = Driver::where('id', $id)->first();


    	$data = [
            'category_name' => 'components',
            'page_name' => 'drivers_edit',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        
        return view('driver.edit', compact('driver'))->with($data);


    }

    public function change_user_status(Request $request){

        Driver::where('id', $request->id)->update(['is_active' => $request->status]);
    return 'success';
    }

    public function driver_edit_post(Request $request){

    	$data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'approval_state' => $request->approval_state,
            'is_active' => $request->is_active,
            'is_available' => $request->is_available,
            'is_phone_verified' => $request->is_phone_verified,
        ]; 

        Driver::where('id', $request->driver_id)->update($data);

    	return redirect()->back()->with('success', 'Updated Successfully!');

    }

    public function driver_vehicle_edit(Request $request){

        $front_photo_name = NULL;
        $back_photo_name = NULL;
        $destinationPath = public_path('/uploads/vehicle');

        if($request->vehicle_id == 0){
        if($request->file('front_photo')){
            $front_photo = $request->file('front_photo');
            $front_photo_name = rand().'-'.time().'.'.$front_photo->getClientOriginalExtension();
            $front_photo->move($destinationPath, $front_photo_name);
        }

        if($request->file('back_photo')){
            $back_photo = $request->file('back_photo');
            $back_photo_name = rand().'-'.time().'.'.$back_photo->getClientOriginalExtension();
            $back_photo->move($destinationPath, $back_photo_name);
        }
       }else{
         
         $vehicle = Vehicle::where('id', $request->vehicle_id)->first();
        if(!is_null($vehicle)){
         if($request->file('front_photo')){
            $front_photo = $request->file('front_photo');
            $front_photo_name = rand().'-'.time().'.'.$front_photo->getClientOriginalExtension();
            $front_photo->move($destinationPath, $front_photo_name);
        }else{
           $front_photo_name = $vehicle->front_photo;
        }

        if($request->file('back_photo')){
            $back_photo = $request->file('back_photo');
            $back_photo_name = rand().'-'.time().'.'.$back_photo->getClientOriginalExtension();
            $back_photo->move($destinationPath, $back_photo_name);
        }else{
            $back_photo_name = $vehicle->back_photo;
        }
        }
       }
    
        $data = [
            'driver_id' => $request->driver_id,
            'maker' => $request->maker,
            'model' => $request->model,
            'year' => $request->year,
            'licence_plate' => $request->licence_plate,
            'color' => $request->color,
            'front_photo' => $front_photo_name,
            'back_photo' => $back_photo_name,
        ];

        if($request->vehicle_id == 0){
            Vehicle::insert($data);
        }else{
            Vehicle::where('id', $request->vehicle_id)->update($data);
        }

        return redirect()->back()->with('success', 'Updated Successfully!');

    }

    public function vehicle_docment(Request $request){

    $destinationPath = public_path('/uploads/vehicle');
     if($request->file('document')){
            $photo = $request->file('document');
            $photo_name = rand().'-'.time().'.'.$photo->getClientOriginalExtension();
            $photo->move($destinationPath, $photo_name);

           $data = [
            'model_type' => 'App\Models\Vehicle',
            'model_id' => $request->vehicle_id,
            'image' => $photo_name
           ];

            Document::insert($data);
           
           return redirect()->back()->with('success', 'Updated Successfully!');

        }


    }

    


}
