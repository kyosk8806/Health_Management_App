<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Record;
use App\Models\User;

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
        $month = Carbon::now()->format("m");
        $year = Carbon::now()->format("Y");
        $user_id = Auth::user()->id;
        $records = Record::with('user')->where('user_id', $user_id)->whereMonth('date', $month)->whereYear('date', $year)->orderBy('date', 'desc')->get();

        $getNext = MonthYear::getNext($month, $year);
        $getPrev = MonthYear::getPrev($month, $year);
        $lineChart = LineChart::lineChart($month, $year);
        $bmi = Bmi::bmi($user_id, $month, $year);

        $user_data = User::where('id', $user_id)->get();
        $target = $user_data[0]['target_weight'];

        return view('records.index', [
            'records' => $records,
            'next_month' => $getNext['month'], 
            'next_year' => $getNext['year'], 
            'prev_month' => $getPrev['month'],
            'prev_year' => $getPrev['year'],
            'month' => $month,
            'year' => $year,
            'latest_record' => $bmi['latest_record']['weight'],
            'bmi' => $bmi['bmi'],
            'msg' => $bmi['msg'],
            'date' => $lineChart['date'],
            'weight' => $lineChart['weight'],
            'step' => $lineChart['step'],
            'target' => $target,
        ]);
        
        return view('home');
    }
}
