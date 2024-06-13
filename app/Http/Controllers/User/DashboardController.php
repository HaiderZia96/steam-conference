<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard
     */
    public function index(){
        $data = array(
            'page_title' => 'Dashboard',
            'p_title'=>'Dashboard',
        );
        return view('user.dashboard')->with($data);
    }
}
