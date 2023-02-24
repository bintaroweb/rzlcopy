<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{
    /**
     * Create a middleware auth.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('outlet.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $customers = Outlet::where('user_id', Auth::user()->parent_id);

        return DataTables::of($customers)
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
        $provinces = DB::table('provinces')->orderBy('name')->get();
        return view('outlet.create', ['provinces' => $provinces]);
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
            'name' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',         
        ]);

        $outlet = Outlet::create([
            'name' => $request->name, 
            'province_id' => $request->province,
            'city_id' => $request->city,
            'district_id' => $request->district,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        $payments = ['cash', 'gopay', 'ovo', 'dana', 'linkaja', 'shoppepay', 'gofood', 'grabfood', 'shoppefood', 'otheronlinedelivery',
            'bca', 'mandiri', 'bni', 'bri', 'cimbniaga', 'bsi', 'otheredc', 'tokopedia', 'shoppe', 'otherecommerce', 
            'whatsappp', 'transfer', 'flazz', 'brizzi', 'emoney'];

        $payment_method = implode(',', $payments);

        Payment::create([
            'outlet_id' => $outlet->id,
            'payment_method' => $payment_method
        ]);

        return redirect('/outlets')->with('success', 'Outlet berhasil ditambah');
        
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
        $outlet = Outlet::where('uuid', $uuid)->first();
        $provinces = DB::table('provinces')->orderBy('name')->get();
        $cities = DB::table('cities')->where('province_id', $outlet->province_id)->orderBy('name')->get();
        $districts = DB::table('districts')->where('city_id', $outlet->city_id)->orderBy('name')->get();
        return view('outlet.edit', [
            'outlet' => $outlet, 'provinces' => $provinces, 'cities' => $cities, 'districts' => $districts
        ]);
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
            'name' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',         
        ]);

        Outlet::where('uuid', $uuid)
            ->update([
                'name' => $request->name, 
                'province_id' => $request->province,
                'city_id' => $request->city,
                'district_id' => $request->district,
                'address' => $request->address,
                'phone' => $request->phone,
            ]);

        return redirect('/outlets')->with('success', 'Outlet berhasil diubah');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        Outlet::where('uuid', $uuid)->delete();
        return redirect('/outlets')->with('success', 'Outlet berhasil dihapus');
    }
}
