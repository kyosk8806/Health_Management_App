<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;
    protected $fillable = [
        'date', 'weight', 'step', 'exercise', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
