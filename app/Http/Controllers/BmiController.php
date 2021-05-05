<?php

namespace App\Http\Controllers;

use App\Http\Controllers\RecordController;
use App\Models\Record;
use App\Models\User;

class Bmi extends RecordController
{
    public static function bmi($user_id)
    {
        // Latest record data
        $latest_record = Record::with('user')->where('user_id', $user_id)->orderBy('date', 'desc')->first();

        $user_data = User::where('id', $user_id)->get();
        $height = $user_data[0]['height'];
        $registered_weight = $user_data[0]['weight'];

        // BMI
        $bmi = number_format($latest_record['weight'] / ($height * $height), 2);
        if ($bmi > 25) {
            $msg = 'Over Weight';
        } elseif (($bmi >= 18.5) && ($bmi <= 25)) {
            $msg = 'Normal Weight';
        } else {
            $msg = 'Under Weight';
        }

        $bmi = [
            'latest_record' => $latest_record,
            'bmi' => $bmi,
            'msg' => $msg,
        ];
        return $bmi;
    }
}