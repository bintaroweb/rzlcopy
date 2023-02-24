<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class TechnicianController extends Controller
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
        return view('technician.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $technicians = Technician::all();
        return DataTables::of($technicians)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('technician.create');
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
            'contact'  => 'required|string'        
        ]);

        Technician::create([
            'name' => $request['name'],
            'contact' => $request['contact']
        ]);

        return redirect('/technicians')->with('success', 'Teknisi berhasil ditambah');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $data = Technician::where('uuid', $uuid)->first();
        return view('technician.edit', ['technician' => $data]);
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
            'contact'  => 'required|string'        
        ]);

        Technician::where('uuid', $uuid)
                ->update([
                    'name' => $request->name, 
                    'contact' => $request->contact
                ]);
        
         return redirect('/technicians')->with('success', 'Teknisi berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        Technician::where('uuid', $uuid)->delete();
        return redirect('/technicians')->with('success', 'Teknisi berhasil dihapus');
    }
}
