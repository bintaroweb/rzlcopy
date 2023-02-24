<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Customer;
use App\Models\DeliveryDetail;
use App\Models\Machine;
use App\Models\Product;
use App\Models\Record;
use App\Models\Technician;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class RecordController extends Controller
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
            ->select('products.name as name', 'machines.id as id')
            ->where('machines.customer_id', '=', $customer->id)
            ->where('machines.deleted_at', '=', null)
            ->get();

        // dd($machines);       

        return view('record.index', ['customer' => $customer, 'machines' => $machines]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable(Request $request)
    {
        $customer = Customer::where('uuid', $request->id)->first();
        if(empty($request->machine)){
            $records = Record::select("*")
                ->where('customer_id', $customer->id)
                ->orderByDesc("id")
                ->get();
        } else {
            $records = Record::select("*")
                ->where('customer_id', $customer->id)
                ->where('machine_id', $request->machine)
                ->orderByDesc("id")
                ->get();
        }
        
        $array = [];

        foreach($records as $record) {
            $technician = Technician::where('id', $record->technician_id)->first();
            $machine = DB::table('products')
                ->join('machines', 'products.id', '=', 'machines.product_id')
                ->select('products.name as name', 'machines.id as id')
                ->where('machines.id', '=', $record->machine_id)
                ->first();

            $data['uuid'] = $record->uuid;
            $data['date'] = date('d-m-Y', strtotime($record->date));
            $data['machine'] = $machine->name;
            $data['problem'] = $record->problem;
            $data['description'] = $record->description;
            $data['counter'] = $record->counter;
            if($record->source == 'csv'){
                $data['technician'] = $record->technician_id;
            } else {
                $data['technician'] = $technician->name;
            }

            array_push($array, $data);
        }

        // dd($array);

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
        // $data = [];
  
        if($request->filled('q')){
            $customers = Technician::select("name", "id")
                        ->where('name', 'LIKE', '%'. $request->get('q'). '%')
                        ->get();
        } else {
            $customers = Technician::all();
        }
    
        return response()->json($customers);
    }

    public function import(Request $request)
    {
        $file = $request->file("upload");
        // dd($file);

        if ($file) {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize(); //Get size of uploaded file in bytes
            //Check for file extension and size
            $this->checkUploadedFileProperties($extension, $fileSize);
            //Where uploaded file will be stored on the server
            $location = "uploads"; //Created an "uploads" folder for that
            // Upload file
            $file->move($location, $filename);
            // In case the uploaded file path is to be stored in the database
            $filepath = public_path($location . "/" . $filename);
            // Reading file
            $file = fopen($filepath, "r");
            $importData_arr = []; // Read through the file and store the contents as an array
            $i = 0;
            //Read the contents of the uploaded file
            while (($filedata = fgetcsv($file, 1000, ",")) !== false) {
                $num = count($filedata);
                // Skip first row (Remove below comment if you want to skip the first row)
                if ($i == 0) {
                    $i++;
                    continue;
                }
                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata[$c];
                }
                $i++;
            }
            fclose($file); //Close after reading
            $j = 0;
            // dd($importData_arr);
            foreach ($importData_arr as $importData) {
                // $j++;
                // dd($importData[1]);
                // echo $j;
                Record::create([
                    "customer_id" => $request->customer,
                    "problem" => $importData[1],
                    "description" => $importData[2],
                    "technician_id" => $importData[3],
                    "date" => $importData[5],
                    "counter" => $importData[4],
                    "source" => 'csv',
                ]);
            }
            // return response()->json([
            //     "message" => "$j records successfully uploaded",
            // ]);
            return redirect('/records/?id='. $request->customer)->with('success', 'Machine Record berhasil diimport');
        } else {
            //no file was uploaded
            throw new \Exception(
                "No file was uploaded",
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = ["csv", "xlsx"]; //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {
            } else {
                throw new \Exception(
                    "No file was uploaded",
                    Response::HTTP_REQUEST_ENTITY_TOO_LARGE
                ); //413 error
            }
        } else {
            throw new \Exception(
                "Invalid file extension",
                Response::HTTP_UNSUPPORTED_MEDIA_TYPE
            ); //415 error
        }
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
        $machines = DB::table('products')
            ->join('machines', 'products.id', '=', 'machines.product_id')
            ->select('products.name as name', 'machines.id as id')
            ->where('machines.customer_id', '=', $customer->id)
            ->where('machines.deleted_at', '=', null)
            ->get();

        // $machines = DB::table('products')
        //     ->join('machines', 'products.id', '=', 'machines.product_id')
        //     ->select('products.name as name', 'machines.id as id')
        //     ->where('machines.customer_id', '=', $customer->id)
        //     ->get();
        // dd($machines);
        $technicians = Technician::all();
        
        // dd($customer->id);

        return view('record.create', ['customer' => $uuid, 'machines' => $machines, 'technicians' => $technicians]);
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
            'problem' => 'nullable|string',         
            'description' => 'required|string',         
            'counter' => 'required|string',         
            'customer' => 'required',         
            'technician' => 'required',         
        ]);

        $customer = Customer::where('uuid', $request->customer)->first();

        // dd($request->customer);

        Record::create([
            'date' => $request->date, 
            'problem' => $request->problem,
            'description' => $request->description,
            'counter' => $request->counter,
            'customer_id' => $customer->id,
            'machine_id' => $request->machine,
            'technician_id' => $request->technician,
        ]);

        return redirect('/records/?id='. $request->customer)->with('success', 'Machine Record berhasil ditambah');
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
    public function edit($uuid)
    {
        $record = Record::where('uuid', $uuid)->first();
        $customer = $record->customer_id;
        $technician = Technician::where('id', $record->technician_id)->first();

        return view('record.edit', ['record' => $record, 'customer' => $customer, 'technician' => $technician]);
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
            'problem' => 'nullable|string',         
            'description' => 'required|string',         
            'counter' => 'required|string',         
            'customer' => 'required',         
            'technician' => 'required',         
        ]);

        Record::where('uuid', $uuid)
        ->update([
            'date' => $request->date, 
            'problem' => $request->problem,
            'description' => $request->description,
            'counter' => $request->counter,
            'customer_id' => $request->customer,
            'technician_id' => $request->technician,
        ]);

        $customer = Customer::where('id', $request->customer)->first();

        return redirect('/records/?id='. $customer->uuid)->with('success', 'Machine Record berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $record = Record::where('uuid', $uuid)->first();
        $customer = Customer::where('id', $record->customer_id)->first();
        Record::where('uuid', $uuid)->delete();
        // dd($customer->uuid);
        return redirect('/records/?id='. $customer->uuid)->with('success', 'Machine Record berhasil dihapus');
    }
}
