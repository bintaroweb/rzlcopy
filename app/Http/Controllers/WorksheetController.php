<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Customer;
use App\Models\Technician;
use DataTables;

class WorksheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $technicians = Technician::all();
        return view('worksheet.print', ['technicians' =>  $technicians]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cetak(Request $request)
    {
        // dd($request->technician);

        $schedules = Schedule::select("*")
                        ->where('technician_id', $request->technician)
                        ->whereDate('date', $request->date)
                        ->orderByDesc("id")
                        ->get();
        $array = [];

        foreach($schedules as $schedule){
            $data['uuid'] = $schedule->uuid;
            $data['date'] = date('d-m-Y', strtotime($schedule->date));
            $data['contact'] = $schedule->contact;
            $data['address'] = $schedule->address;
            $data['problem'] = $schedule->problem;
            $data['description'] = '';

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
