<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'note',
        'amount',
        'term_months',
        'interest_rate',
        'start_date',
        'status', // Active, Delete, in_progress, paid
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
