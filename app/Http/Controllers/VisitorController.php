<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
class VisitorController extends Controller
{
    public function index(Request $request) {
    
        $ipAddress   = $_SERVER['REMOTE_ADDR'];
        $currentDate = date('o-m-d');
        $currentTime = date('H:i:s');
        Visitor::create([
            'ip_address'   => $ipAddress,
            'visited_date' => $currentDate,
            'visited_time' => $currentTime,
        ]);
        return response(1); 
    }
}