<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Machine;
use App\Models\Status;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customer = Customer::where('uuid', $request->id)->first();
        $machines = DB::table('products')
            ->join('machines', 'products.id', '=', 'machines.product_id')
            ->where('machines.customer_id', '=', $customer->id)
            ->where('machines.deleted_at', '=', null)
            ->select('products.name as name', 'machines.id as id')
            ->get();  
        
        // dd($machines);

        return view('machine.index', ['customer' => $customer, 'machines' => $machines]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable(Request $request)
    {
        $customer = Customer::where('uuid', $request->id)->first();
        $machines = DB::table('products')
                ->join('machines', 'products.id', '=', 'machines.product_id')
                ->join('status', 'status.id', '=', 'machines.status')
                ->where('machines.customer_id', $customer->id)
                ->select('products.name as machine', 'machines.*', 'status.status as status')
                ->get();

        $machine_list = [];

        foreach($machines as $machine){
            $data['uuid'] = $machine->uuid;
            $data['date'] = date('d-m-Y', strtotime($machine->date));
            $data['machine'] = $machine->machine;
            $data['status'] = $machine->status;
            $data['description'] = $machine->description;


            array_push($machine_list, $data);
        }

        // dd($machine_list);

        return DataTables::of($machine_list)
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
    public function create(Request $request)
    {
        $uuid = $request->id;
        $customer = Customer::where('uuid', $uuid)->first();
        // dd($customer->customer_name);
        $status = Status::all();
        return view('machine.create', ['customer_id' => $uuid, 'customer_name' => $customer->customer_name, 'status' => $status]);
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
            'date' => 'required',     
            'machine' => 'required|string', 
            'status' => 'required|string',
            'description' => 'nullable|string',     
        ]);

        $customer = Customer::where('uuid', $request->customer)->first();

        Machine::create([
            'date' => $request->date, 
            'product_id' => $request->machine,
            'customer_id' => $customer->id,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect('/machines/?id='. $request->customer)->with('success', 'Mesin Fotocopy berhasil ditambah');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $machine = DB::table('products')
            ->join('machines', 'products.id', '=', 'machines.product_id')
            ->join('status', 'status.id', '=', 'machines.status')
            ->where('machines.uuid', $uuid)
            ->select('products.name as machine', 'machines.*', 'status.status as status', 'status.id as status_id')
            ->first();

        $customer = Customer::where('id', $machine->customer_id)->first();

        $status = Status::all();
        return view('machine.edit', [ 'machine_id' => $machine->uuid, 'machine_name' => $machine->machine, 
            'customer_id' => $customer->id, 'customer_name' => $customer->customer_name, 
            'status' => $status, 'status_id' => $machine->status_id, 'date' => $machine->date ]);
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
        $request->validate([
            'date' => 'required',     
            'machine' => 'required|string', 
            'status' => 'required|string',
            'description' => 'nullable|string',     
        ]);

        Machine::where('uuid', $uuid)
        ->update([
            'date' => $request->date, 
            'product_id' => $request->machine,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        $customer = Customer::where('id', $request->customer)->first();

        return redirect('/machines/?id='. $customer->uuid)->with('success', 'Machine Record berhasil diubah');
    }
}
