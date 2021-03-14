<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\User;

use App\Http\Controllers\LineChart;
use App\Http\Controllers\MonthYear;
use App\Http\Controllers\Bmi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{
    private $month;
    private $year;

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
            'user_data' => $user_data[0],
        ]);
    }

    public function create()
    {
        return view('records.index');
    }

    public function store(RecordRequest $request)
    {
        $record = new Record;
        $record->user_id = $request->user()->id;
        $record->date = $request->date;
        $record->weight = $request->weight;
        $record->step = $request->step;
        $record->exercise = $request->exercise;
        $record->note = $request->note;
        $record->save();
        // print_r(schema::getColumnListing('records'));
        $month = $this->month;
        $year = $this->year;

        return redirect(route('records.index', [
            'month' => $month,
            'year' => $year,
        ]));
    }

    public function update(RecordRequest $request, $id)
    {
        $records = Record::find($request->id);
        print_r($records);
        exit;
        $records->weight = $request->weight;
        $records->step = $request->step;
        $records->exercise = $request->exercise;
        $records->note = $request->note;

        $records->save();
        $month = $this->month;
        $year = $this->year;
        
        return redirect(route('records.index', [
            'month' => $month,
            'year' => $year,
        ]));
    }

    public function destroy($id)
    { 
        Record::find($id)->delete();

        $month = $this->month;
        $year = $this->year;
    
        return redirect(route('records.index', [
            'month' => $month,
            'year' => $year,
        ]));
    }

    public function profileUpdate(Request $request, $id)
    {
        $params = [
            'id' => $request->id,
            'name' => $request->name,
            'age' => $request->age,
            'height' => $request->height,
            'target_weight' => $request->target_weight,
        ];

        DB::update('update users set name =:name, age =:age, height =:height, target_weight =:target_weight where id =:id', $params);
        
        $month = $this->month;
        $year = $this->year;
        
        return redirect(route('records.index', [
            'month' => $month,
            'year' => $year,
        ]));
    }

}
