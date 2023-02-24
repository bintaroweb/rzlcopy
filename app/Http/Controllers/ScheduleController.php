<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Schedule;
use App\Models\Technician;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Console\Scheduling\Schedule as SchedulingSchedule;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
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
        return view('schedule.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $schedules = Schedule::select("*")
                        ->orderByDesc("id")
                        ->get();
        $array = [];
        

        foreach($schedules as $schedule){
            $data['uuid'] = $schedule->uuid;
            $data['date'] = date('d-m-Y', strtotime($schedule->date));
            $data['contact'] = $schedule->contact;
            $data['address'] = $schedule->address;
            $data['problem'] = $schedule->problem;

            $customer = Customer::where('id', $schedule->customer_id)->first();
            
            if(is_null($customer->customer_company) || $customer->customer_name == $customer->customer_company){
                $data['customer'] = $customer->customer_name;
            } else {
                $data['customer'] = $customer->customer_name . ' (' . $customer->customer_company . ')';
            }

            if($schedule->technician_id == 0){
                $data['technician'] = "";
            } else {
                $technician = Technician::where('id', $schedule->technician_id)->first();
                $data['technician'] = $technician->name;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cetak(Request $request)
    {
        $schedules = Schedule::select("*")
                        ->where('date', $request->date)
                        ->orderByDesc("id")
                        ->get();
        $array = [];

        foreach($schedules as $schedule){
            $data['uuid'] = $schedule->uuid;
            $data['date'] = date('d-m-Y', strtotime($schedule->date));
            $data['contact'] = $schedule->contact;
            $data['address'] = $schedule->address;
            $data['problem'] = $schedule->problem;

            $customer = Customer::where('id', $schedule->customer_id)->first();
            
            if(is_null($customer->customer_company) || $customer->customer_name == $customer->customer_company){
                $data['customer'] = $customer->customer_name;
            } else {
                $data['customer'] = $customer->customer_name . ' (' . $customer->customer_company . ')';
            }

            if($schedule->technician_id == 0){
                $data['technician'] = "";
            } else {
                $technician = Technician::where('id', $schedule->technician_id)->first();
                $data['technician'] = $technician->name;
            }

            $product = Product::where('id', $schedule->product_id)->first();
            $data['product'] = $product->name;

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
            $customers = Customer::select("customer_name", "id", "customer_company")
                        ->where('customer_name', 'LIKE', '%'. $request->get('q'). '%')
                        ->orWhere('customer_company', 'LIKE', '%'. $request->get('q'). '%')
                        ->get();
            foreach($customers as $customer){
                if(is_null($customer->customer_company) || $customer->customer_name == $customer->customer_company){
                    $customer['id'] = $customer->id;
                    $customer['customer_name'] = $customer->customer_name;
                } else {
                    $customer['id'] = $customer->id;
                    $customer['customer_name'] = $customer->customer_name . ' (' . $customer->customer_company . ')';
                }
            }  
            array_push($data, $customer);

            // dd($customers);

        } else {
            $customers = Customer::all();
            foreach($customers as $customer){
                if(is_null($customer->customer_company) || $customer->customer_name == $customer->customer_company){
                    $customer['id'] = $customer->id;
                    $customer['customer_name'] = $customer->customer_name;
                } else {
                    $customer['id'] = $customer->id;
                    $customer['customer_name'] = $customer->customer_name . ' (' . $customer->customer_company . ')';
                }
            }  
            array_push($data, $customer);
        }
    
        return response()->json($customers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function address(Request $request)
    {
        $data = Customer::where('id', $request->customer)->first();
    
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $technicians = Technician::all();
        return view('schedule.create', ['technicians' =>  $technicians]);
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
            'customer' => 'required|string',
            'address' => 'required|string',
            'contact' => 'required|string',
            'technician' => 'nullable|string',
            'problem' => 'required|string'        
        ]);

        Schedule::create([
            'date' => $request['date'],
            'customer_id' => $request['customer'],
            'address' => $request['address'], 
            'contact' => $request['contact'], 
            'technician_id' => $request['technician'], 
            'problem' => $request['problem'], 
            'product_id' => $request['product'], 
        ]);

        $customer = Customer::where('id', $request['customer'])->first();
        if(is_null($customer->customer_address)){
            Customer::where('id', $request['customer'])
                ->update([
                    'customer_address' => $request['address']
                ]);
        }

        return redirect('/schedules')->with('success', 'Jadwal berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print()
    {
        return view('schedule.print');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $schedule = Schedule::where('uuid', $uuid)->first();
        $customer = Customer::where('id', $schedule->customer_id)->first();
        $technicians = Technician::all();
        return view('schedule.edit', ['schedule' => $schedule, 'technicians' =>  $technicians, 'customer' => $customer]);
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
            'customer' => 'required|string',
            'address' => 'required|string',
            'contact' => 'required|string',
            'technician' => 'nullable|string',
            'problem' => 'required|string'        
        ]);

        Schedule::where('uuid', $uuid)
        ->update([
            'date' => $request['date'],
            'customer_id' => $request['customer'],
            'address' => $request['address'], 
            'contact' => $request['contact'], 
            'technician_id' => $request['technician'], 
            'problem' => $request['problem'], 
            'product_id' => $request['product'],
        ]);

        return redirect('/schedules')->with('success', 'Jadwal berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        Schedule::where('uuid', $uuid)->delete();
        return redirect('/schedules')->with('success', 'Jadwal berhasil dihapus');
    }
}
