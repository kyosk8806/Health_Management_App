<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecordRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Record;
use App\Models\User;
use Carbon\Carbon;

class RecordController extends Controller
{

    public function __construct()
    {
        $month = Carbon::now()->format("m");
        $year = Carbon::now()->format("Y");
        $this->middleware('auth');
    }

    public function index($month, $year)
    {
        $user_id = Auth::user()->id;
        $records = Record::with('user')->where('user_id', $user_id)->whereMonth('date', $month)->whereYear('date', $year)->get();
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
        $records = Record::create($request->all());

        return redirect('/records');
    }

    public function show(Record $record)
    {
        //
    }

    public function edit(Record $record)
    {
        //
    }

    public function update(RecordRequest $request, Record $record)
    {
        //
    }

    public function destroy($id)
    {
        Record::find($id)->delete();

        return redirect('/records');
    }

    public function getNext($month, $year)
    {           
        if ($month == 12) {
            $month = 01;
            $year = $year + 1;
        } else {
            $month = $month + 1;
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
            $month = $month - 1;
            $year = $year;
        }
        $getPrev = [
            'month' => $month,
            'year' => $year,
        ];
        return $getPrev;
    }

}
