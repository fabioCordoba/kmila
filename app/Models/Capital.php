<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capital extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'description',
        'with_partner',
        'type', // in, out, loan, investment
        'status', // Active, Delete
    ];
}
