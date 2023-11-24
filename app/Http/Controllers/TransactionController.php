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

class TransactionController extends Controller
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
            'title' => 'Add New Transaction',
        ];
        return view('transaction.insert', $data);
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try{
            DB::table('transactions')->where('id', $id )->delete();

            DB::commit();

            return redirect( '/transaction' )
                    ->with('status', "Success");
        } catch(\Exception $e) {
            dd($e->getMessage()); exit;
            DB::rollBack();
            return redirect( '/transaction' )
                ->with('status', "Failed");
        }
    }

    public function detail($id)
    {
        $query = DB::table('transactions')
                ->selectRaw('
                    transactions.*,
                    customers.customer_title, customers.customer_address, customers.customer_phone_no, customers.customer_email
                ')
                ->join('customers', 'transactions.customer_id', '=', 'customers.id')
                ->orderBy('transactions.id', 'DESC')
                ->where('transactions.id', $id)
                ->get()
                ->first();

        $query_detail = DB::table('transaction_details')
                ->selectRaw('
                    transaction_details.*,
                    products.product_title
                ')
                ->join('products', 'transaction_details.product_id', '=', 'products.id')
                ->where('transaction_details.transaction_id', $id)
                ->orderBy('transaction_details.id', 'ASC')
                ->get();
        
        $data = [
            'dbrow' => (array) $query,
            'details' => $query_detail,
            'menuActive' => '', 
            'title' => 'Transaction Detail',
        ];
        return view('transaction.detail', $data);
    }

    public function edit($id)
    {
        $query = DB::table('transactions')
                ->selectRaw('
                    transactions.*,
                    customers.customer_title, customers.customer_address, customers.customer_phone_no, customers.customer_email
                ')
                ->join('customers', 'transactions.customer_id', '=', 'customers.id')
                ->orderBy('transactions.id', 'DESC')
                ->where('transactions.id', $id)
                ->get()
                ->first();

        $query_detail = DB::table('transaction_details')
                ->selectRaw('
                    transaction_details.*,
                    products.product_title
                ')
                ->join('products', 'transaction_details.product_id', '=', 'products.id')
                ->where('transaction_details.transaction_id', $id)
                ->orderBy('transaction_details.id', 'ASC')
                ->get();
        
        $data = [
            'dbrow' => (array) $query,
            'details' => $query_detail,
            'menuActive' => '', 
            'title' => 'Transaction Update',
        ];
        return view('transaction.update', $data);
    }

    public function ganjil_genap(){
        $data = [
            'menuActive' => '', 
            'title' => 'Ganjil Genap',
        ];
        return view('transaction.ganjil-genap', $data);
    }

    public function getcustomers(Request $request)
    {
        $key = $request->q;
        $csrftoken = $request->csrftoken;
        $result = '';
        if($request->q != ''):
            $query = DB::table('customers')
                    ->selectRaw('customers.*')
                    ->where(DB::raw('lower(customers.customer_title)'), 'like', '%'. $request->q. '%')
                    ->orderBy('customers.customer_title', 'ASC')
                    ->get();
            if($query):
                foreach($query as $row):
                    echo $row->customer_title ."|". $row->id ."|". $row->customer_address . "|" . $row->customer_email . "|" . $row->customer_phone_no . "\n";
                endforeach;
            endif;
        else:
           echo ''; 
        endif;
        exit;
    }

    public function getproducts(Request $request)
    {
        $key = $request->q;
        $csrftoken = $request->csrftoken;
        $result = '';
        if($request->q != ''):
            $query = DB::table('products')
                    ->selectRaw('products.*')
                    ->where(DB::raw('lower(products.product_title)'), 'like', '%'. $request->q. '%')
                    ->orderBy('products.product_title', 'ASC')
                    ->get();
            if($query):
                foreach($query as $row):
                    echo $row->product_title ."|". $row->id ."|". $row->product_price . "\n";
                endforeach;
            endif;
        else:
           echo ''; 
        endif;
        exit;
    }

    public function index()
    {
        $query = DB::table('transactions')
                ->selectRaw('
                    transactions.*,
                    customers.customer_title
                ')
                ->join('customers', 'transactions.customer_id', '=', 'customers.id')
                ->orderBy('transactions.id', 'DESC')
                ->get();
        
        $data = [
            'dataTables' => $query,
            'menuActive' => '', 
            'title' => 'Transaction List',
        ];
        return view('transaction.index', $data);
    }

    public function insert(Request $request)
    {
        DB::beginTransaction();

        try{
            if($request->inputCustomerId == ''):
                $insertCustomer = DB::table('customers')
                            ->insertGetId([
                                'customer_title' => $request->inputCustomerName,
                                'customer_slug' => $request->inputCustomerName.'-'.date('ymdhis'),
                                'customer_address' => ($request->inputCustomerAddress != '' ? $request->inputCustomerAddress : NULL),
                                'customer_phone_no' => ($request->inputCustomerPhone != '' ? $request->inputCustomerPhone : NULL),
                                'customer_email' => ($request->inputCustomerEmail != '' ? $request->inputCustomerEmail : NULL),
                                'created_at' => Carbon::now()
                            ]);
                $customer_id = $insertCustomer;
            else:
                $customer_id = $request->inputCustomerId;
            endif;

            $input_id = $request->item_id;
            $input_qty = $request->item_qty;
            $input_price = $request->item_price;
            $input_discount = $request->item_discount;
            $input_subtotal = $request->item_subtotal;
            $input_length = count($input_id);
            $total_qty = 0;
            $total_price = 0.00;
            $total_discount = 0.00;
            $exists_id = [];
            //$findkey = null;

            if($input_length > 0):
                for($x=0 ; $x<$input_length ; $x++):
                    if($input_id[$x] != ''):
                        //$findkey = null;
                        if(count($exists_id) == 0):
                            $exists_id[] = [
                                'product_id' => $input_id[$x],
                                'qty' => $input_qty[$x],
                                'price' => $input_price[$x],
                                'discount' => $input_discount[$x],
                                'subtotal' => $input_subtotal[$x]
                            ];
                            //array_push($exists_id, $newarr);
                        elseif(count($exists_id) > 0):
                            $key = array_search($input_id[$x], array_column($exists_id, 'product_id'));
                            $findkey = $key;

                            //dump($findkey);

                            if($findkey):
                                $exists_id[$key]['qty'] += $input_qty[$x];
                                $exists_id[$key]['price'] += $input_price[$x];
                                $exists_id[$key]['discount'] += $input_discount[$x];
                                $exists_id[$key]['subtotal'] += $input_subtotal[$x];
                            else:
                                $exists_id[] = [
                                    'product_id' => $input_id[$x],
                                    'qty' => $input_qty[$x],
                                    'price' => $input_price[$x],
                                    'discount' => $input_discount[$x],
                                    'subtotal' => $input_subtotal[$x]
                                ];
                                //array_push($exists_id, $newarr);
                            endif;
                        endif;

                        $total_qty += $input_qty[$x];
                        $total_price += ($input_price[$x]*$input_qty[$x]);
                        $total_discount += $input_discount[$x];
                    endif;
                endfor;
            endif;

            //dump($exists_id);exit;

            try{
                $insertTransaction = DB::table('transactions')
                                    ->insertGetId([
                                'customer_id' => $customer_id,
                                'transaction_date' => Carbon::now(),
                                'total_qty' => $total_qty,
                                'total_price' => $total_price,
                                'total_discount' => $total_discount,
                                'total_subtotal' => $request->total_subtotal,
                                'total_freight' => $request->total_freight,
                                'grand_total' => $request->grand_total,
                                'total_payment' => $request->total_paid,
                                'total_change_due' => $request->change_due,
                                'created_at' => Carbon::now()
                            ]);

                if(count($exists_id) > 0):
                    //for($x=0 ; $x<count($exists_id) ; $x++):
                    for($x=0 ; $x<count($exists_id) ; $x++):
                        try{
                            $insertTransactionDetail = DB::table('transaction_details')
                                                ->insertGetId([
                                            'transaction_id' => $insertTransaction,
                                            'product_id' => $exists_id[$x]['product_id'],
                                            'qty' => $exists_id[$x]['qty'],
                                            'price' => $exists_id[$x]['price'],
                                            'discount' => $exists_id[$x]['discount'],
                                            'subtotal' => $exists_id[$x]['subtotal'],
                                            'created_at' => Carbon::now()
                                        ]);
                        } catch(\Exception $e) {
                            dd($e->getMessage()); exit;
                            DB::rollBack();
                            $data = [
                                'menuActive' => '', 
                                'title' => 'Add New Transaction',
                            ];
                        }
                    endfor;
                endif;

                // $testins = DB::table('test')
                //             ->insertGetId([
                //             'id' => Uuid::uuid4(),
                //             'created_at' => Carbon::now()
                //         ]);

                DB::commit();

                return redirect( '/transaction' )
                    ->with('status', "Success");

            } catch(\Exception $e) {
                dd($e->getMessage()); exit;
                DB::rollBack();
                return redirect( '/transaction/create' )
                    ->with('status', "Failed");
            }

        } catch(\Exception $e) {
            dd($e->getMessage()); exit;
            DB::rollBack();
            return redirect( '/transaction/create' )
                    ->with('status', "Failed"); 
        }
    }

    public function update(Request $request)
    {
        $id = $request->trans_id;

        $avail_id = [];
        $avail_detail_id = [];
        $exists_id = [];
        //$findkey = null;

        $query_detail = DB::table('transaction_details')
                ->selectRaw('
                    transaction_details.*,
                    products.product_title
                ')
                ->join('products', 'transaction_details.product_id', '=', 'products.id')
                ->where('transaction_details.transaction_id', $id)
                ->orderBy('transaction_details.id', 'ASC')
                ->get();
        if(count($query_detail) > 0):
            foreach($query_detail as $row):
                array_push($avail_id, $row->product_id);
                array_push($avail_detail_id, $row->id);
            endforeach;
        endif;

        DB::beginTransaction();

        try{
            $detail_id = $request->detail_id;
            $input_id = $request->item_id;
            $input_qty = $request->item_qty;
            $input_price = $request->item_price;
            $input_discount = $request->item_discount;
            $input_subtotal = $request->item_subtotal;
            $input_length = count($input_id);
            $total_qty = 0;
            $total_price = 0.00;
            $total_discount = 0.00;
            $remove_id = [];

            if($input_length > 0):
                for($x=0 ; $x<$input_length ; $x++):
                    if($input_id[$x] != ''):
                        //$findkey = null;
                        if(count($exists_id) == 0):
                            $exists_id[] = [
                                'detail_id' => $detail_id[$x],
                                'product_id' => $input_id[$x],
                                'qty' => $input_qty[$x],
                                'price' => $input_price[$x],
                                'discount' => $input_discount[$x],
                                'subtotal' => $input_subtotal[$x]
                            ];
                            //array_push($exists_id, $newarr);
                        elseif(count($exists_id) > 0):
                            $key = array_search($input_id[$x], array_column($exists_id, 'product_id'));
                            $findkey = $key;

                            if($findkey):
                                $exists_id[$key]['qty'] += $input_qty[$x];
                                $exists_id[$key]['price'] += $input_price[$x];
                                $exists_id[$key]['discount'] += $input_discount[$x];
                                $exists_id[$key]['subtotal'] += $input_subtotal[$x];
                            else:
                                $exists_id[] = [
                                    'detail_id' => $detail_id[$x],
                                    'product_id' => $input_id[$x],
                                    'qty' => $input_qty[$x],
                                    'price' => $input_price[$x],
                                    'discount' => $input_discount[$x],
                                    'subtotal' => $input_subtotal[$x]
                                ];
                                //array_push($exists_id, $newarr);
                            endif;
                        endif;

                        $total_qty += $input_qty[$x];
                        $total_price += ($input_price[$x]*$input_qty[$x]);
                        $total_discount += $input_discount[$x];
                    endif;
                endfor;
            endif;

            $updateTransaction = DB::table('transactions')
                            ->where('id', $id)
                            ->update([
                                'total_qty' => $total_qty,
                                'total_price' => $total_price,
                                'total_discount' => $total_discount,
                                'total_subtotal' => $request->total_subtotal,
                                'total_freight' => $request->total_freight,
                                'grand_total' => $request->grand_total,
                                'total_payment' => $request->total_paid,
                                'total_change_due' => $request->change_due,
                                'updated_at' => Carbon::now()
                            ]);

            if(count($exists_id) > 0):
                for($x=0 ; $x<count($exists_id) ; $x++):
                    if($exists_id[$x]['product_id'] != '' && $exists_id[$x]['detail_id'] == ''):
                        try{
                            $insertTransactionDetail = DB::table('transaction_details')
                                                ->insertGetId([
                                            'transaction_id' => $id,
                                            'product_id' => $exists_id[$x]['product_id'],
                                            'qty' => $exists_id[$x]['qty'],
                                            'price' => $exists_id[$x]['price'],
                                            'discount' => $exists_id[$x]['discount'],
                                            'subtotal' => $exists_id[$x]['subtotal'],
                                            'created_at' => Carbon::now()
                                        ]);
                        } catch(\Exception $e) {
                            dd($e->getMessage()); exit;
                            DB::rollBack();
                            $data = [
                                'menuActive' => '', 
                                'title' => 'Add New Transaction',
                            ];
                        }
                    elseif($exists_id[$x]['product_id'] != '' && $exists_id[$x]['detail_id'] != ''):
                        try{
                            $updateTransactionDetail = DB::table('transaction_details')
                                                ->where('id', $exists_id[$x]['detail_id'])
                                                ->update([
                                            'product_id' => $exists_id[$x]['product_id'],
                                            'qty' => $exists_id[$x]['qty'],
                                            'price' => $exists_id[$x]['price'],
                                            'discount' => $exists_id[$x]['discount'],
                                            'subtotal' => $exists_id[$x]['subtotal'],
                                            'updated_at' => Carbon::now()
                                        ]);
                        } catch(\Exception $e) {
                            dd($e->getMessage()); exit;
                            DB::rollBack();
                            $data = [
                                'menuActive' => '', 
                                'title' => 'Add New Transaction',
                            ];
                        }
                    endif;
                endfor;
            endif;

            if(count($avail_id) > 0):
                for($x=0 ; $x<count($avail_id) ; $x++):
                    if(!in_array($avail_id[$x], $input_id)):
                        try{
                            $deleteTransactionDetail = DB::table('transaction_details')->where('id', $avail_detail_id[$x])->where('product_id', $avail_id[$x])->delete();
                        } catch(\Exception $e) {
                            dd($e->getMessage()); exit;
                            DB::rollBack();
                            $data = [
                                'menuActive' => '', 
                                'title' => 'Add New Transaction',
                            ];
                        }
                    endif;
                endfor;
            endif;

            DB::commit();

            return redirect( '/transaction' )
                ->with('status', "Success");
        } catch(\Exception $e) {
            dd($e->getMessage()); exit;
            DB::rollBack();
            return redirect( '/transaction/edit/' . $id )
                    ->with('status', "Failed"); 
        }
    }
}