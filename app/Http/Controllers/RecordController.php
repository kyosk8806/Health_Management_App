<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecordRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Record;
use App\Models\User;
use Carbon\Carbon;

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
        $getNext = $this->getNext($month, $year);
        $getPrev = $this->getPrev($month, $year);
        
        return view('records.index', [
            'records' => $records,
            'next_month' => $getNext['month'], 
            'next_year' => $getNext['year'], 
            'prev_month' => $getPrev['month'],
            'prev_year' => $getPrev['year'],
            'month' => $month,
            'year' => $year,
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

        $month = $this->month;
        $year = $this->year;

        return redirect(route('records.index', [
            'month' => $month,
            'year' => $year,
        ]));
    }

    public function show(Record $record)
    {
        //
    }

    public function edit(RecordRequest $request, $id)
    {
        $records = Record::find($request->id);

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
        $records->weight = $request->weight;
        $records->step = $request->step;
        $records->exercise = $request->exercise;
        $records->note = $request->note;

        $records->save();
        return redirect('/records');
    }

    public function destroy($id)
    {
        print_r($id);
        exit;
        Record::find($id)->delete();

        return redirect('/records');
    }

    public function getNext($month, $year)
    {           
        if ($month == 12) {
            $month = 01;
            $year = $year + 1;
        } else {
            $month = (int)$month + 1;
            $year = $year;
        }
        $getNext = [
            'month' => $month,
            'year' => $year,
        ];
        return $getNext;
    }

    public function getPrev($month, $year)
    {           
        if ($month == 01) {
            $month = 12;
            $year = $year - 1;
        } else {
            $month = (int)$month - 1;
            $year = $year;
        }
        $getPrev = [
            'month' => $month,
            'year' => $year,
        ];
        return $getPrev;
    }

}
