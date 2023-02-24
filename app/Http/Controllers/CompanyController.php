<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
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
        //
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
     * Display city resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function city(Request $request)
    {
        $data['cities'] = DB::table('cities')->where('province_id', $request->prov_id)->orderBy('name')->get(["name", "id"]);
        return response()->json($data);
    }

    /**
     * Display district resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function district(Request $request)
    {
        $data['districts'] = DB::table('districts')->where('city_id', $request->city_id)->orderBy('name')->get(["name", "id"]);
        // foreach($cities as $city => $c){
        //     return "<option value=$c->city_id>$c->city_name</option>";
        // }

        return response()->json($data);
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
     * Show the form for editing the company profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $company = Company::where("user_id", Auth::user()->parent_id)->first();
        $provinces = DB::table('provinces')->orderBy('name')->get();
        $cities = DB::table('cities')->where('province_id', $company->province_id)->orderBy('name')->get();
        $districts = DB::table('districts')->where('city_id', $company->city_id)->orderBy('name')->get();
        return view('company.edit', ['company' => $company, 'provinces' => $provinces, 
        'cities' => $cities, 'districts' => $districts,]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'postal_code' => 'nullable|string',           
            'website' => 'nullable|string'           
        ]);

        Company::where('user_id', Auth::user()->parent_id)
        ->update([
            'name' => $request->name, 
            'category' => $request->category,
            'province_id' => $request->province,
            'city_id' => $request->city,
            'district_id' => $request->district,
            'address' => $request->address,
            'phone' => $request->phone,
            'postal_code' => $request->postal_code,
            'website' => $request->website,
        ]);

        return redirect('/settings/company/edit')->with('success', 'Informasi Bisnis berhasil diubah');;
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
