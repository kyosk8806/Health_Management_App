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
        $records = Record::with('user')->where('user_id', $user_id)->orderBy('date', 'desc')->whereMonth('date', $month)->whereYear('date', $year)->get();
        $next_month = $this->getNextMonth($month);
        $next_year = $this->getNextYear($month, $year);
        $prev_month = $this->getPrevMonth($month);
        $prev_year = $this->getPrevYear($month,$year);
        
        return view('records.index', [
            'records' => $records,
            'next_month' => $next_month, 
            'next_year' => $next_year, 
            'prev_month' => $prev_month,
            'prev_year' => $prev_year,  
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

    public function getNextMonth($month)
    {           
        if ($month == 12) {
            $month = 01;
        } else {
            $month = $month + 1;
        }
        return $month;
    }

    public function getNextYear($month, $year)
    {           
        if ($month == 12) {
            $year = $year + 1;
        } else {
            $year = $year;
        }
        return $year;
    }

    public function getPrevMonth($month)
    {           
        if ($month == 01) {
            $month = 12;
        } else {
            $month = $month - 1;
        }
        return $month;
    }

    public function getPrevYear($month, $year)
    {           
        if ($month == 01) {
            $year = $year - 1;
        } else {
            $year = $year;
        }
        return $year;
    }

}
