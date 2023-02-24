<?php

namespace App\Http\Controllers;

use App\Models\SalesType;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class SalesTypeController extends Controller
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
        return view('salestype.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        // return Customer::all()->toJson();
        $sales = SalesType::all();

        return DataTables::of($sales)
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
        $request->validate([
            'name' => 'required|string',            
        ]);

        SalesType::create([
            'name' => $request['name']
        ]);

        return response()->json([
            'success' => 'Tipe Penjualan berhasil ditambah'
        ]);
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
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',            
        ]);

        SalesType::where('uuid', $request->uuid)->update([
            'name' => $request['name']
        ]);

        return response()->json([
            'success' => 'Tipe Penjualan berhasil diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        SalesType::where('uuid', $request->uuid)->delete();
        
        return response()->json([
            'success' => 'Tipe Penjualan berhasil dihapus'
        ]);
    }
}
