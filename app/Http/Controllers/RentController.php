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

use DateTime;
use Session;

class RentController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    public function create()
    {
        $option_customers = DB::table('customers')
                ->selectRaw('
                    customers.*
                ')
                ->orderBy('customers.customer_title', 'DESC')
                ->get();

        $option_cars = DB::table('cars')
                ->selectRaw('
                    cars.*
                ')
                ->orderBy('cars.car_title', 'DESC')
                ->get();

    	$data = [
            'menuActive' => '', 
            'option_cars' => $option_cars,
            'option_customers' => $option_customers,
            'title' => 'Add New Rent',
        ];
        return view('rent.insert', $data);
    }

    public function delete($id)
    {
        $query = DB::table('rents')->where('id', $id)->get()->first();

        if(count( (array)$query ) > 0){
            return redirect( '/car' )
                ->with('status', "Failed");
        }else{
            $dbrow = (array)$query;

            if($dbrow['date_of_return'] == ""):
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
            else:
                return redirect( '/car' )
                ->with('status', "Failed");
            endif;
            
        }
    }

    public function detail($id)
    {
        $query = DB::table('rents')
                ->selectRaw('
                    rents.*,
                    customers.customer_title,
                    cars.car_title
                ')
                ->join('customers', 'rents.customer_id', '=', 'customers.id')
                ->join('cars', 'rents.car_id', '=', 'cars.id')
                ->where('rents.id', $id)
                ->get()
                ->first();
        
        $data = [
            'dbrow' => (array) $query,
            'menuActive' => '', 
            'title' => 'car Detail',
        ];
        return view('rent.detail', $data);
    }

    public function edit($id)
    {
        $query = DB::table('rents')
                ->selectRaw('
                    rents.*,
                    customers.customer_title,
                    cars.car_title
                ')
                ->join('customers', 'rents.customer_id', '=', 'customers.id')
                ->join('cars', 'rents.car_id', '=', 'cars.id')
                ->where('rents.id', $id)
                ->get()
                ->first();

        $option_customers = DB::table('customers')
                ->selectRaw('
                    customers.*
                ')
                ->orderBy('customers.customer_title', 'DESC')
                ->get();

        $option_cars = DB::table('cars')
                ->selectRaw('
                    cars.*
                ')
                ->orderBy('cars.car_title', 'DESC')
                ->get();
        
        $data = [
            'dbrow' => (array) $query,
            'menuActive' => '', 
            'option_cars' => $option_cars,
            'option_customers' => $option_customers,
            'title' => 'car Update',
        ];
        return view('rent.update', $data);
    }

    public function get_nums_between_date(Request $request)
    {
        $datefrom = $request->start_date; 
        $dateto = $request->end_date; 
        if($datefrom != '' && $dateto != ''){
            $datefrom = new DateTime( SetDateFormatFromID($datefrom, 'Y-m-d') );
            $dateto = new DateTime( SetDateFormatFromID($dateto, 'Y-m-d') );
            $interval = $datefrom->diff($dateto);
            echo $interval->format('%y|%m|%d'); exit;
        }else{
            echo ""; exit;
        }
    }

    public function check_car_availability_by_date(Request $request){
        $car_id = $request->val; 
        $datefrom = $request->start_date; 
        $dateto = $request->end_date;
        if($car_id != '' && $datefrom != '' && $dateto != ''){
            $datefrom = new DateTime( SetDateFormatFromID($datefrom, 'Y-m-d') );
            $dateto = new DateTime( SetDateFormatFromID($dateto, 'Y-m-d') );

            $check1 = DB::table('rents')
                    ->where('car_id', $car_id)
                    ->where('start_date', '>=',$datefrom)
                    ->where('end_date', '<=',$dateto)
                    ->get();

            if(count($check1) > 0):
                echo "NOT OK"; exit;
            else:
                echo "OK"; exit;
            endif;
        }else{
            echo ""; exit;
        }
    }

    public function index()
    {
        $query = DB::table('rents')
                ->selectRaw('
                    rents.*,
                    customers.customer_title,
                    cars.car_title
                ')
                ->join('customers', 'rents.customer_id', '=', 'customers.id')
                ->join('cars', 'rents.car_id', '=', 'cars.id')
                ->orderBy('cars.car_title', 'DESC')
                ->get();
        
        $data = [
            'dataTables' => $query,
            'menuActive' => '', 
            'title' => 'car List',
        ];
        return view('rent.index', $data);
    }

    public function insert(Request $request)
    {
        DB::beginTransaction();

        $total_days = 0;
        if($request->days_no != ''):
            $total_days += $request->days_no;
        endif;
        if($request->extends_day != ''):
            $total_days += $request->extends_day;
        endif;

        try{
            $insertRent = DB::table('rents')
                            ->insertGetId([
                                'customer_id' => ($request->customer_id != '' ? $request->customer_id : NULL),
                                'car_id' => ($request->car_id != '' ? $request->car_id : NULL),
                                'start_date' => ($request->start_date != '' ? convertDateTime($request->start_date, 'Y-m-d') : NULL),
                                'end_date' => ($request->end_date != '' ? convertDateTime($request->end_date, 'Y-m-d') : NULL),
                                'range_days' => ($request->days_no != '' ? $request->days_no : 0),
                                'rent_price' => ($request->car_rent_price != '' ? $request->car_rent_price : 0),
                                'total_price' => ($request->total_price != '' ? $request->total_price : 0),
                                'grand_total' => ($request->grand_total != '' ? $request->grand_total : 0),
                                'rent_status' => 'rent',
                                'return_date' => ($request->date_of_return != '' ? convertDateTime($request->date_of_return, 'Y-m-d') : NULL),
                                'extends_day' => ($request->extends_day != '' ? $request->extends_day : 0),
                                'total_days' => $total_days,
                                'booking_paid' => ($request->dp_paid != '' ? $request->dp_paid : 0),
                                'created_at' => Carbon::now()
                            ]);
            $rent_id = $insertRent;

            if($request->date_of_return != ''):
                try{
                    $updateCar = DB::table('cars')
                        ->where('id', $request->car_id)
                        ->update([
                            'is_available' => 'yes',
                            'not_available_from' => NULL,
                            'not_available_to' => NULL
                        ]);
                } catch(\Exception $e) {
                    dd($e->getMessage()); exit;
                    DB::rollBack();
                    return redirect( '/rent/create' )
                            ->with('status', "Failed"); 
                }
            else:
                try{
                    $updateCar = DB::table('cars')
                        ->where('id', $request->car_id)
                        ->update([
                            'is_available' => 'no',
                            'not_available_from' => ($request->start_date != '' ? convertDateTime($request->start_date, 'Y-m-d') : NULL),
                            'not_available_to' => ($request->end_date != '' ? convertDateTime($request->end_date, 'Y-m-d') : NULL),
                            'updated_at' => Carbon::now()
                        ]);
                } catch(\Exception $e) {
                    dd($e->getMessage()); exit;
                    DB::rollBack();
                    return redirect( '/rent/create' )
                            ->with('status', "Failed"); 
                }
            endif;

            DB::commit();

            return redirect( '/rent' )
                    ->with('status', "Success");

        } catch(\Exception $e) {
            dd($e->getMessage()); exit;
            DB::rollBack();
            return redirect( '/rent/create' )
                    ->with('status', "Failed"); 
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();

        $total_days = 0;
        if($request->days_no != ''):
            $total_days += $request->days_no;
        endif;
        if($request->extends_day != ''):
            $total_days += $request->extends_day;
        endif;

        try{
            $updateTransaction = DB::table('rents')
                ->where('id', $request->inputId)
                ->update([
                    'customer_id' => ($request->customer_id != '' ? $request->customer_id : NULL),
                    'car_id' => ($request->car_id != '' ? $request->car_id : NULL),
                    'start_date' => ($request->start_date != '' ? convertDateTime($request->start_date, 'Y-m-d') : NULL),
                    'end_date' => ($request->end_date != '' ? convertDateTime($request->end_date, 'Y-m-d') : NULL),
                    'range_days' => ($request->days_no != '' ? $request->days_no : 0),
                    'rent_price' => ($request->car_rent_price != '' ? $request->car_rent_price : 0),
                    'total_price' => ($request->total_price != '' ? $request->total_price : 0),
                    'grand_total' => ($request->grand_total != '' ? $request->grand_total : 0),
                    'rent_status' => 'rent',
                    'return_date' => ($request->date_of_return != '' ? convertDateTime($request->date_of_return, 'Y-m-d') : NULL),
                    'extends_day' => ($request->extends_day != '' ? $request->extends_day : 0),
                    'total_days' => $total_days,
                    'booking_paid' => ($request->dp_paid != '' ? $request->dp_paid : 0),
                    'updated_at' => Carbon::now()
                ]);

            if($request->car_id != $request->lastCar):
                try{
                    $updateCar = DB::table('cars')
                        ->where('id', $request->lastCar)
                        ->update([
                            'is_available' => 'yes',
                            'not_available_from' => NULL,
                            'not_available_to' => NULL
                        ]);
                } catch(\Exception $e) {
                    dd($e->getMessage()); exit;
                    DB::rollBack();
                    return redirect( '/rent/edit/' . $request->inputId )
                            ->with('status', "Failed"); 
                }
            endif;

            if($request->date_of_return != ''):
                try{
                    $updateCar = DB::table('cars')
                        ->where('id', $request->car_id)
                        ->update([
                            'is_available' => 'yes',
                            'not_available_from' => NULL,
                            'not_available_to' => NULL
                        ]);
                } catch(\Exception $e) {
                    dd($e->getMessage()); exit;
                    DB::rollBack();
                    return redirect( '/rent/edit/' . $request->inputId )
                            ->with('status', "Failed"); 
                }
            else:
                try{
                    $updateCar = DB::table('cars')
                        ->where('id', $request->car_id)
                        ->update([
                            'is_available' => 'no',
                            'not_available_from' => ($request->start_date != '' ? convertDateTime($request->start_date, 'Y-m-d') : NULL),
                            'not_available_to' => ($request->end_date != '' ? convertDateTime($request->end_date, 'Y-m-d') : NULL),
                            'updated_at' => Carbon::now()
                        ]);
                } catch(\Exception $e) {
                    dd($e->getMessage()); exit;
                    DB::rollBack();
                    return redirect( '/rent/edit/' . $request->inputId )
                            ->with('status', "Failed"); 
                }
            endif;

            DB::commit();

            return redirect( '/rent' )
                ->with('status', "Success");
        } catch(\Exception $e) {
            dd($e->getMessage()); exit;
            DB::rollBack();
            return redirect( '/car/edit/' . $id )
                    ->with('status', "Failed"); 
        }
    }
}