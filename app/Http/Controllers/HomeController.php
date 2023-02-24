<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = Schedule::where('date', date('Y-m-d'))->count();
        $tommorow = Schedule::where('date', date('Y-m-d', strtotime('+1 days')))->count();
        $technician = DB::table('schedules')
                        ->where('date', '=', date('Y-m-d'))
                        ->where('technician_id', '!=', null)
                        ->groupBy('technician_id')
                        ->count();
        // dd($technician);
        return view('home', ['today' => $today, 'tommorow' => $tommorow, 'technician' => $technician]);
    }
}
