<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Role;
use App\Models\User;
use App\Models\UserOutlet;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        return view('user.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $users = DB::table('users')->get(); 

        $data = [];

        foreach($users as $user => $value){
            $user = [];
            $user['name'] = $value->name;
            $user['role'] = $value->role;
            $user['uuid'] = $value->uuid;

            $outlets = explode(',', $value->outlets);

            $user['outlet'] = [];

            foreach($outlets as $outlet => $v){
                $cabangs = DB::table('outlets')
                        ->where('id', $v)
                        ->get();

                foreach($cabangs as $cabang => $c){
                        array_push($user['outlet'], $c->name);
                }
            }

            $user['outlet'] = implode(', ', $user['outlet']);

            array_push($data, $user);

        }

        return DataTables::of($data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $outlets = Outlet::where('user_id', Auth::user()->parent_id);
        $roles = Role::where('user_id', Auth::user()->parent_id);
        return view('user.create', ['outlets' => $outlets, 'roles' => $roles]);
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
            'email'  => 'required|string',
            'role_id' => 'required',
            'password' => 'required|string',
            'outlet' => 'required'           
        ]);
        
        // $parent = ['parent_id' => Auth::user()->parent_id];
        // $request->merge($parent);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role_id' => $request['role_id'],
            'parent_id' => Auth::user()->parent_id
        ]);

        $outlet = implode(',', $request->outlet);
        
        $user_outlet = [
            'user_id' => $user->id,
            'outlet_id' => $outlet
        ];

        // dd($user_outlet);

        UserOutlet::create($user_outlet);

        // foreach($request->outlet as $outlet){
        //     $user_outlet = [
        //         'user_id' => $user->id,
        //         'outlet_id' => $outlet
        //     ];

        //     UserOutlet::create($user_outlet);
        // }
        
        return redirect('/users')->with('success', 'Karyawan berhasil ditambah');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $data = DB::table('users')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->where('role_id', '!=', '0') //Exclude Owner
                ->where('users.uuid', '=', $uuid)
                ->select('users.*', 'users.uuid as uuid', 'roles.name as role')
                ->first(); 

        $user_outlets = DB::table('user_outlets')
                ->where('user_outlets.user_id', '=', $data->id)
                ->first(); 

        $data->outlet = explode(',', $user_outlets->outlet_id);

        $roles = Role::all();
        $outlets = Outlet::all();
        return view('user.edit', ['user' => $data, 'roles' => $roles, 'outlets' => $outlets]);
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
            'role_id' => 'required',
            'password' => 'nullable|string'           
        ]);

        if(!empty($request->password)){
            User::where('uuid', $uuid)
                ->update([
                    'name' => $request->name, 
                    'role_id' => $request->role_id,
                    'password' => Hash::make($request->password)
                ]);
        } else {
            User::where('uuid', $uuid)
                ->update([
                    'name' => $request->name, 
                    'role_id' => $request->role_id 
                ]);
        }

        $outlets = implode(',', $request->outlet);

        UserOutlet::where('user_id', $request->user)->update(['outlet_id' => $outlets]);

        // DB::table('user_outlets')->where('user_id', '=', $request->user)->get(); 

        // foreach($request->outlet as $outlet){
        //     $outlet = DB::table('user_outlets')->where('id', '!=', $outlet)->where('user_id', '=', $request->user)->get(); 

        //     dd($outlet);
        //     $user_outlet = [
        //         'outlet_id' => $outlet
        //     ];

        //     UserOutlet::where('uuid', $uuid)
        //         ->update([
        //             'name' => $request->name, 
        //             'role_id' => $request->role_id,
        //             'password' => Hash::make($request->password)
        //         ]);

        //     UserOutlet::create($user_outlet);
        // }

        return redirect('/users')->with('success', 'Pelanggan berhasil diubah');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        User::where('uuid', $uuid)->delete();
        return redirect('/users')->with('success', 'Karyawan berhasil dihapus');
    }
}
