<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class kisahController extends Controller
{
    public function getKisah($id){
        $kisah = DB::select('select * from kisah where user_id = ?', [$id]);
        return $kisah;
    }
    
    public function getAllKisah(){
        $kisah = DB::select('select * from kisah');
        return $kisah;
    }
}
