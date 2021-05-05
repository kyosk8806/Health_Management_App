<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Csv extends Controller
{
    public function __construct()
    {
        $this->month = Carbon::now()->format("m");
        $this->year = Carbon::now()->format("Y");
        $this->middleware('auth');
    }

    public static function download($month, $year)
    {
        $user_id = Auth::user()->id;
        $params = [
            'id' => $user_id,
            'month' => $month,
            'year' => $year,
        ];

        $deleteColumns = ['id', 'created_at', 'updated_at'];
        $getColumnLists = schema::getColumnListing('records');
        // Array to String
        $columnLists = implode(",", array_diff($getColumnLists, $deleteColumns));
        $sql = "select {$columnLists} from records where year(`date`) = :year and month(`date`) = :month and user_id = :id order by date ASC";

        $user_data = DB::select($sql, $params);
        $records = json_decode(json_encode($user_data), true);

        // File type（csv）
        header('Content-Type: application/octet-stream');
        // File name
        header("Content-Disposition: attachment; filename={$month}_{$year}.csv");
        header('Content-Transfer-Encoding: binary');
     
        $csv = "";
        $columns ="";
        foreach($records as $record){
            $columns = join(",", array_keys($record))."\n";
            $csv .= join(",", array_values($record))."\n";
        }
        return $columns.$csv;
    }  
}