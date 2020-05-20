<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('dashboard');
    }

    public function persons(){
        return view('system.accessibility.persons');
    }
    
    public function users(){
        return view('system.accessibility.users');
    }

    public function equipments(){
        return view('system.motorpol.equipments');
    }

    public function repair_job_orders(){
        return view('system.motorpol.repair_job_orders');
    }

    public function inventory(){
        return view('system.inventory.inventory');
    }

    public function inventory_stocks(){
        return view('system.inventory.inventory_stocks');
    }

}
