<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Customer;
use App\Models\Machine;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Create a middleware auth.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('additional')->only('edit','update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $customers = Customer::select("*")
                        ->orderByDesc("id")
                        ->get();
        $array = [];

        foreach($customers as $customer){
            $data['uuid'] = $customer->uuid;
            $data['customer_name'] = $customer->customer_name;
            $data['customer_company'] = $customer->customer_company;
            $data['customer_phone'] = $customer->customer_phone;
            $data['customer_email'] = $customer->customer_email;
            $data['customer_address'] = $customer->customer_address;

            $city = City::where('id', $customer->customer_city)->first();
            $data['customer_city'] = $city->name;

            $status = Status::where('id', $customer->customer_status)->first();
            if(!empty($status)){
                $data['customer_status'] = $status->status;
            } else {
                $data['customer_status'] = '';
            }
            

            array_push($array, $data);
        }

        

        return DataTables::of($array)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-primary btn-sm btn-edit">Edit</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = [];
  
        if($request->filled('q')){
            $data = City::select("name", "id")
                        ->where('name', 'LIKE', '%'. $request->get('q'). '%')
                        ->get();
        }
    
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function machines(Request $request)
    {
        $data = [];
  
        $data = Product::select("name", "id")
                ->where('name', 'LIKE', '%'. $request->get('q'). '%')
                ->get();
    
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = Status::all();
        return view('customer.create', ['status' => $status]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'customer_company' => 'nullable|string',
            'customer_phone' => 'required|string',
            'customer_email' => 'nullable|string',
            'customer_address' => 'nullable|string',
            'customer_city' => 'required|string',
            'customer_note' => 'nullable|string',            
            // 'customer_status' => 'required|string',            
            'date' => 'nullable|string',            
        ]);

        $customer = Customer::create($request->all());

        $customerId = $customer->id;
        $customerUuid = $customer->uuid;

        // dd(count($request->machine));

        for($i = 0; $i <= count($request->machine) -1; $i++)
        {
            Machine::create([
                'product_id' => $request->machine[$i],
                'customer_id' => $customerId,
            ]);
        }

        if($request->ajax()){
            return response()->json([
                'success' => true,
                'id' => $customerId
            ]);
        }      

        return redirect('/customers/'.$customerUuid)->with('success', 'Pelanggan berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $data = Customer::where('uuid', $uuid)->first();

        // dd($data);

        if(is_null($data->customer_status)) {
            $customer = DB::table('customers')
            ->join('cities', 'customers.customer_city', '=', 'cities.id')
            // ->join('status', 'customers.customer_status', '=', 'status.id')
            ->select('customers.*', 'cities.name as city')
            ->where('uuid', '=', $uuid)
            ->first();

            $machines = DB::table('products')
                ->join('machines', 'products.id', '=', 'machines.product_id')
                ->select('products.name as name', 'machines.id as id')
                ->where('machines.customer_id', '=', $customer->id)
                ->get();

            // dd($machines);
            // echo "Status Null";

            return view('customer.show', ['customer' => $customer, 'status' => null, 'machines' => $machines]);
        } else{
            $customer = DB::table('customers')
                ->join('cities', 'customers.customer_city', '=', 'cities.id')
                ->join('status', 'customers.customer_status', '=', 'status.id')
                ->select('customers.*', 'cities.name as city', 'status.status as status')
                ->where('uuid', '=', $uuid)
                ->first();

             $machines = DB::table('products')
                ->join('machines', 'products.id', '=', 'machines.product_id')
                ->select('products.name as name', 'machines.id as id')
                ->where('machines.customer_id', '=', $customer->id)
                ->get();

            // dd($machines);

            return view('customer.show', ['customer' => $customer, 'status' => $customer->status, 'machines' => $machines]);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        // $data = Customer::where('uuid', $uuid)->first();
        $customer = DB::table('customers')
            ->join('cities', 'customers.customer_city', '=', 'cities.id')
            // ->join('status', 'customers.customer_status', '=', 'status.id')
            ->select('customers.*', 'cities.name as city', 'cities.id as city_id')
            ->where('uuid', '=', $uuid)
            ->first();

        $machines = DB::table('products')
            ->join('machines', 'products.id', '=', 'machines.id')
            ->select('products.name as name', 'machines.id as id')
            ->get();

        // $status = Status::all();

        // dd($machines);
        
        // return view('customer.edit', ['customer' => $customer, 'status' => $status, 'machines' => $machines]);
        return view('customer.edit', ['customer' => $customer, 'machines' => $machines]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        // dd($request);

        $request->validate([
            'customer_name' => 'required|string',
            'customer_company' => 'nullable|string',
            'customer_phone' => 'required|string',
            'customer_email' => 'nullable|string',
            'customer_address' => 'nullable|string',
            'customer_city' => 'required|string',
            'customer_note' => 'nullable|string',                               
            // 'customer_status' => 'required|string',                               
            'date' => 'nullable|string',                
        ]);

        if($request->customer_city === null){
            Customer::where('uuid', $uuid)
                ->update([
                    'customer_name' => $request->customer_name, 
                    'customer_phone' => $request->customer_phone, 
                    'customer_email' => $request->customer_email, 
                    'customer_company' => $request->customer_company, 
                    'customer_address' => $request->customer_address, 
                    // 'customer_city' => $request->customer_city, 
                    'customer_status' => $request->customer_status, 
                    'customer_note' => $request->customer_note, 
                    'date' => $request->date, 
                ]);
        } else {
            Customer::where('uuid', $uuid)
                ->update([
                    'customer_name' => $request->customer_name, 
                    'customer_phone' => $request->customer_phone, 
                    'customer_email' => $request->customer_email, 
                    'customer_company' => $request->customer_company, 
                    'customer_address' => $request->customer_address, 
                    'customer_city' => $request->customer_city, 
                    'customer_note' => $request->customer_note, 
                    'customer_status' => $request->customer_status,
                    'date' => $request->date, 
                ]);
        }
        
        for($i = 0; $i <= count($request->machine) -1; $i++)
        {
            Machine::where('product_id', [
                'product_id' => $request->machine[$i],
                'customer_id' => $customerId,
            ]);
        }

        return redirect('/customers')->with('success', 'Pelanggan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        Customer::where('uuid', $uuid)->delete();
        return redirect('/customers')->with('success', 'Pelanggan berhasil dihapus');
    }
}