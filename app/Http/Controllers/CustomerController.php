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

class CustomerController extends Controller
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
            'title' => 'Add New Customer',
        ];
        return view('customer.insert', $data);
    }

    public function delete($id)
    {
        $query = DB::table('rents')->where('customer_id', $id)->get()->first();

        if(count( (array)$query ) > 0){
            return redirect( '/customer' )
                ->with('status', "Failed");
        }else{
            DB::beginTransaction();

            try{
                DB::table('customers')->where('id', $id )->delete();

                DB::commit();

                return redirect( '/customer' )
                        ->with('status', "Success");
            } catch(\Exception $e) {
                dd($e->getMessage()); exit;
                DB::rollBack();
                return redirect( '/customer' )
                    ->with('status', "Failed");
            }
        }
    }

    public function detail($id)
    {
        $query = DB::table('customers')
                ->selectRaw('
                    customers.*
                ')
                ->orderBy('customers.customer_title', 'DESC')
                ->where('customers.id', $id)
                ->get()
                ->first();
        
        $data = [
            'dbrow' => (array) $query,
            'menuActive' => '', 
            'title' => 'Customer Detail',
        ];
        return view('customer.detail', $data);
    }

    public function edit($id)
    {
        $query = DB::table('customers')
                ->selectRaw('
                    customers.*
                ')
                ->orderBy('customers.customer_title', 'DESC')
                ->where('customers.id', $id)
                ->get()
                ->first();
        
        $data = [
            'dbrow' => (array) $query,
            'menuActive' => '', 
            'title' => 'Customer Update',
        ];
        return view('customer.update', $data);
    }

    public function index()
    {
        $query = DB::table('customers')
                ->selectRaw('
                    customers.*
                ')
                ->orderBy('customers.customer_title', 'DESC')
                ->get();
        
        $data = [
            'dataTables' => $query,
            'menuActive' => '', 
            'title' => 'Customer List',
        ];
        return view('customer.index', $data);
    }

    public function insert(Request $request)
    {
        DB::beginTransaction();

        try{
            $insertCustomer = DB::table('customers')
                            ->insertGetId([
                                'customer_title' => $request->inputCustomerName,
                                'customer_slug' => $request->inputCustomerName.'-'.date('ymdhis'),
                                'customer_address' => ($request->inputCustomerAddress != '' ? $request->inputCustomerAddress : NULL),
                                'customer_phone_no' => ($request->inputCustomerPhone != '' ? $request->inputCustomerPhone : NULL),
                                'customer_email' => ($request->inputCustomerEmail != '' ? $request->inputCustomerEmail : NULL),
                                'customer_license_no' => ($request->inputCustomerLicenseNo != '' ? $request->inputCustomerLicenseNo : NULL),
                                'created_at' => Carbon::now()
                            ]);
            $customer_id = $insertCustomer;

            DB::commit();

            return redirect( '/customer' )
                    ->with('status', "Success");

        } catch(\Exception $e) {
            dd($e->getMessage()); exit;
            DB::rollBack();
            return redirect( '/customer/create' )
                    ->with('status', "Failed"); 
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();

        try{
            $updateTransaction = DB::table('customers')
                ->where('id', $request->inputId)
                ->update([
                    'customer_title' => $request->inputCustomerName,
                    'customer_slug' => $request->inputCustomerName,
                    'customer_address' => ($request->inputCustomerAddress != '' ? $request->inputCustomerAddress : NULL),
                    'customer_phone_no' => ($request->inputCustomerPhone != '' ? $request->inputCustomerPhone : NULL),
                    'customer_email' => ($request->inputCustomerEmail != '' ? $request->inputCustomerEmail : NULL),
                    'customer_license_no' => ($request->inputCustomerLicenseNo != '' ? $request->inputCustomerLicenseNo : NULL),
                    'updated_at' => Carbon::now()
                ]);

            DB::commit();

            return redirect( '/customer' )
                ->with('status', "Success");
        } catch(\Exception $e) {
            dd($e->getMessage()); exit;
            DB::rollBack();
            return redirect( '/customer/edit/' . $id )
                    ->with('status', "Failed"); 
        }
    }
}