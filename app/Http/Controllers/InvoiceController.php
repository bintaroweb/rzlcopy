<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\DeliveryDetail;
use App\Models\Product;
use App\Models\Status;
// use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;


class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customer = Customer::where('id', $request->id)->first();
        return view('invoice.index', ['customer' => $customer]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable(Request $request)
    {
        $invoices = Invoice::select("*")
                        ->where('customer_id', $request->id)
                        ->orderByDesc("id")
                        ->get();
        // dd($invoices);
        // foreach($deliveries as $delivery) {
        //     $details = DeliveryDetail::where('delivery_id', $delivery->id)->get();
        //     foreach($details as $detail){
        //         $data['total'] = $detail->total;
        //         $data['product'] = $detail->product;
        //     }

        // }

        return DataTables::of($invoices)
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
    // public function cetak(Request $request)
    // {
    //     $delivery = Delivery::where('uuid', $request->id)->first();
    //     $customer = Customer::where('id', $delivery->customer_id)->first();
    //     $details = DeliveryDetail::where('delivery_id', $delivery->id)->get();

    //     // dd($details);
        
    //     $pdf = PDF::loadView('delivery.pdf', ['delivery' => $delivery, 'customer' => $customer, 'details' => $details]);
    //     return $pdf->stream();
    //     // return $pdf->download('invoice.pdf');

    //     // $pdf = PDF::loadview('delivery.pdf', ['delivery' => $delivery, 'customer' => $customer, 'details' => $details]);
    //     // pdf->setBasePath('path_here');
    //     // $dompdf->set_base_path('localhost/exampls/style.css');
    //     return $pdf->stream();
    // }

    public function cetak(Request $request)
    {        
        $delivery = Delivery::where('uuid', $request->id)->first();
        $customer = Customer::where('id', $delivery->customer_id)->first();
        $details = DeliveryDetail::where('delivery_id', $delivery->id)->get();

        $array = [];

        foreach($details as $detail){
            $data['total'] = $detail->total;
            $data['type'] = $detail->type;
            $product = Product::where('id', $detail->product_id)->first();
            $data['product'] = $product->name;
            $data['description'] = $detail->description;

            array_push($array, $data);
        }

        return view('delivery.print', ['delivery' => $delivery, 'customer' => $customer, 'details' => $array]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customer(Request $request)
    {
        $data = Customer::where('id', $request->id)->first();
    
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $customer = $request->id;
        $delivery = DB::table('deliveries')->orderBy('id', 'DESC')->first();
        $status = Status::all();
        
        $split = explode('/', $delivery->no);
        $no = $split[0] + 1;

        $month = date('m');
        $month = $this->romanNumerals( $month);
        $year = date('Y');

        $number = $no . '/RS/SJ/' . $month . '/' . $year;

        // dd($number);

        return view('invoice.create', ['customer' => $customer, 'number' => $number, 'status' => $status]);
    }

    /**
     * Roman Number.
     *
     * @return \Illuminate\Http\Response
     */

    private function romanNumerals($num){ 
        $n = intval($num); 
        $res = ''; 
    
        /*** roman_numerals array  ***/ 
        $roman_numerals = array( 
            'M'  => 1000, 
            'CM' => 900, 
            'D'  => 500, 
            'CD' => 400, 
            'C'  => 100, 
            'XC' => 90, 
            'L'  => 50, 
            'XL' => 40, 
            'X'  => 10, 
            'IX' => 9, 
            'V'  => 5, 
            'IV' => 4, 
            'I'  => 1); 
    
        foreach ($roman_numerals as $roman => $number){ 
            /*** divide to get  matches ***/ 
            $matches = intval($n / $number); 
    
            /*** assign the roman char * $matches ***/ 
            $res .= str_repeat($roman, $matches); 
    
            /*** substract from the number ***/ 
            $n = $n % $number; 
        } 
    
        /*** return the res ***/ 
        return $res; 
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
            'date' => 'required|string',
            'no' => 'required|string'         
        ]);

        $delivery = Delivery::create([
            'date' => $request->date, 
            'no' => $request->no,
            'customer_id' => $request->customer
        ]);

        $deliveryId = $delivery->id;

        for($i = 1; $i <= count($request->total); $i++)
        {
            DeliveryDetail::create([
                'total' => $request->total[$i],
                'type' => $request->type[$i],
                'product_id' => $request->product[$i],
                'description' => $request->description[$i],
                'delivery_id' => $deliveryId,
            ]);
        }

        return redirect('/deliveries/?id='. $request->customer)->with('success', 'Pelanggan berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $delivery = Delivery::where('uuid', $id)->first();
        $customer = Customer::where('id', $delivery->customer_id)->first();
        $details = DeliveryDetail::where('delivery_id', $delivery->id)->get();

        $array = [];

        foreach($details as $detail){
            $data['total'] = $detail->total;
            $data['type'] = $detail->type;
            $product = Product::where('id', $detail->product_id)->first();
            $data['product'] = $product->name;
            $data['description'] = $detail->description;

            array_push($array, $data);
        }

        // dd($details);

        return view('delivery.show', ['id' => $id, 'delivery' => $delivery, 'customer' => $customer, 'details' => $array]);
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
