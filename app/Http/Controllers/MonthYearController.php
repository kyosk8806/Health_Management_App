<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\RecordController;
use Illuminate\Http\Request;

class MonthYear extends RecordController
{
    // Get next month and year
    public static function getNext($month, $year)
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

    // Get previous month and year
    public static function getPrev($month, $year)
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
