<?php

namespace App\Http\Controllers;
// Carbonを読み込む
use Carbon\Carbon;

class TimeController extends Controller
{
    public function index()
    {
        $dt = Carbon::now(); // Carbonを使って今日の日付を取得
        
        $today = [
            "SubDay" => $dt->subDay,
        ];
        return view('/attendance_list', ['SubDay' => $today]);
    }
    
}