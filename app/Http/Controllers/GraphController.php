<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MonthYear;
use App\Models\User;
use App\Models\Record;
use Carbon\Carbon;


class GraphController extends Controller
{
    public function __construct()
    {
        $this->month = Carbon::now()->format("m");
        $this->year = Carbon::now()->format("Y");
        $this->middleware('auth');
    }

    public function index($month, $year) 
    {
        $user_id = Auth::user()->id;
        $records = Record::with('user')->where('user_id', $user_id)->whereMonth('date', $month)->whereYear('date', $year)->orderBy('date', 'desc')->get();

        $getNext = MonthYear::getNext($month, $year);
        $getPrev = MonthYear::getPrev($month, $year);
        $lineChart = LineChart::lineChart($month, $year);
        $bmi = Bmi::bmi($user_id, $month, $year);

        $user_data = User::where('id', $user_id)->get()->toArray();
        $target = $user_data[0]['target_weight'];

        return view('records.graph', [
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
            'user_data' => $user_data[0],
        ]);
    }
}
