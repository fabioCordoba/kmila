<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capital extends Model
{
    use HasFactory;

    protected $fillable = [
        'finance_id',
        'amount',
        'description',
        'with_partner',
        'type', // requested, in, out, loan, capital_pay,  interest_pay// Solicitado, entrada, salida, préstamo, pago de capital, pago de intereses
        'status', // Active, Delete
    ];

    public function finances()
    {
        return $this->belongsTo('App\Models\Finance', 'finance_id');
    }
}
