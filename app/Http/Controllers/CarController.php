<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Carbon\Carbon;
//use Ramsey\Uuid\Uuid;

use Session;

class CarController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    public function create()
    {
    	$data = [
            'menuActive' => '', 
            'title' => 'Add New car',
        ];
        return view('car.insert', $data);
    }

    public function delete($id)
    {
        $query = DB::table('rents')->where('car_id', $id)->get()->first();

        if(count( (array)$query ) > 0){
            return redirect( '/car' )
                ->with('status', "Failed");
        }else{
            DB::beginTransaction();

            try{
                DB::table('cars')->where('id', $id )->delete();

                DB::commit();

                return redirect( '/car' )
                        ->with('status', "Success");
            } catch(\Exception $e) {
                dd($e->getMessage()); exit;
                DB::rollBack();
                return redirect( '/car' )
                    ->with('status', "Failed");
            }
        }
    }

    public function detail($id)
    {
        $query = DB::table('cars')
                ->selectRaw('
                    cars.*
                ')
                ->orderBy('cars.car_title', 'DESC')
                ->where('cars.id', $id)
                ->get()
                ->first();
        
        $data = [
            'dbrow' => (array) $query,
            'menuActive' => '', 
            'title' => 'car Detail',
        ];
        return view('car.detail', $data);
    }

    public function edit($id)
    {
        $query = DB::table('cars')
                ->selectRaw('
                    cars.*
                ')
                ->orderBy('cars.car_title', 'DESC')
                ->where('cars.id', $id)
                ->get()
                ->first();
        
        $data = [
            'dbrow' => (array) $query,
            'menuActive' => '', 
            'title' => 'car Update',
        ];
        return view('car.update', $data);
    }

    public function index()
    {
        $query = DB::table('cars')
                ->selectRaw('
                    cars.*
                ')
                ->orderBy('cars.car_title', 'DESC')
                ->get();
        
        $data = [
            'dataTables' => $query,
            'menuActive' => '', 
            'title' => 'car List',
        ];
        return view('car.index', $data);
    }

    public function insert(Request $request)
    {
        DB::beginTransaction();

        try{
            $insertcar = DB::table('cars')
                            ->insertGetId([
                                'car_title' => $request->inputcarName,
                                'car_slug' => $request->inputcarName.'-'.date('ymdhis'),
                                'car_brand' => ($request->inputCarBrand != '' ? $request->inputCarBrand : NULL),
                                'car_model' => ($request->inputCarModel != '' ? $request->inputCarModel : NULL),
                                'car_no' => ($request->inputCarNo != '' ? $request->inputCarNo : NULL),
                                'car_rent_price' => ($request->inputCarRentPrice != '' ? $request->inputCarRentPrice : NULL),
                                'is_available' => (isset($request->is_available) && $request->is_available == 'yes' ? 'yes' : 'no'),
                                'not_available_from' => ($request->not_available_from != '' ? $request->not_available_from : NULL),
                                'not_available_to' => ($request->not_available_to != '' ? $request->not_available_to : NULL),
                                'created_at' => Carbon::now()
                            ]);
            $car_id = $insertcar;

            DB::commit();

            return redirect( '/car' )
                    ->with('status', "Success");

        } catch(\Exception $e) {
            dd($e->getMessage()); exit;
            DB::rollBack();
            return redirect( '/car/create' )
                    ->with('status', "Failed"); 
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();

        try{
            $updateTransaction = DB::table('cars')
                ->where('id', $request->inputId)
                ->update([
                    'car_title' => $request->inputcarName,
                    'car_slug' => $request->inputcarName.'-'.date('ymdhis'),
                    'car_brand' => ($request->inputCarBrand != '' ? $request->inputCarBrand : NULL),
                    'car_model' => ($request->inputCarModel != '' ? $request->inputCarModel : NULL),
                    'car_no' => ($request->inputCarNo != '' ? $request->inputCarNo : NULL),
                    'car_rent_price' => ($request->inputCarRentPrice != '' ? $request->inputCarRentPrice : NULL),
                    'is_available' => (isset($request->is_available) && $request->is_available == 'yes' ? 'yes' : 'no'),
                    'not_available_from' => ($request->not_available_from != '' ? $request->not_available_from : NULL),
                    'not_available_to' => ($request->not_available_to != '' ? $request->not_available_to : NULL),
                    'updated_at' => Carbon::now()
                ]);

            DB::commit();

            return redirect( '/car' )
                ->with('status', "Success");
        } catch(\Exception $e) {
            dd($e->getMessage()); exit;
            DB::rollBack();
            return redirect( '/car/edit/' . $id )
                    ->with('status', "Failed"); 
        }
    }
}