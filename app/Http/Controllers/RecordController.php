<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecordRequest;
use App\Models\Record;
use Carbon\Carbon;

class RecordController extends Controller
{
    public $month;
    // public $year;

    public function __construct()
    {
        $this->month = Carbon::now()->format("m");
        // $this->year = Carbon::now()->format("Y");
    }

    public function index($month)
    {
        $records = Record::orderBy('date', 'desc')->whereMonth('date', $month)->get();

        $next_month = $this->getNext($month);
        $prev_month = $this->getPrev($month);

        return view('records.index', [
            'records' => $records,
            'next_month' => $next_month, 
            'prev_month' => $prev_month, 
            'month' => $month,
            // 'year' => $year,
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

    public function getNext($month)
    {           
        if ($month == 12) {
            $month = 01;
        } else {
            $month = $month + 1;
        }
        return $month;
    }

    public function getPrev($month)
    {           
        if ($month == 01) {
            $month = 12;
        } else {
            $month = $month - 1;
        }
        return $month;
    }

    // public function getNext($month, $year)
    // {           
    //     if ($month == 12) {
    //         $month = 01;
    //         $year = $year + 1;
    //     } else {
    //         $month = $month + 1;
    //         $year = $year;
    //     }
    //     return [$month, $year];
    // }

    // public function getPrev($month, $year)
    // {           
    //     if ($month == 01) {
    //         $month = 12;
    //         $year = $year - 1;
    //     } else {
    //         $month = $month - 1;
    //     }
    //     return [$month, $year];
    // }
}
