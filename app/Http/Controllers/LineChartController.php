<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecordRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\MonthYear;
use App\Models\Record;
use App\Models\User;
use Carbon\Carbon;

class LineChart extends RecordController
{
    // Line chart
    public static function lineChart($month, $year) 
    {
        $getNext = MonthYear::getNext($month, $year);
        $getPrev = MonthYear::getPrev($month, $year);

        $user_id = Auth::user()->id;
        $records = Record::with('user')->where('user_id', $user_id)->whereMonth('date', $month)->whereYear('date', $year)->orderBy('date', 'asc')->get();
        
        $data = $records->toArray();
        $date = [];
        foreach ($data as $key => $value) {
            $value = (date('m/d', strtotime($data[$key]['date']))); 
            $date[] = $value;
        }

        $weight = [];
        foreach ($data as $key => $value) {
            $value = $data[$key]['weight']; 
            $weight[] = $value;
        }

        $step = [];
        foreach ($data as $key => $value) {
            $value = $data[$key]['step']; 
            $step[] = $value;
        }

        $lineChart = [
            'date' => $date,
            'weight' => $weight,
            'step' => $step,
        ];
        return $lineChart;
    }
}