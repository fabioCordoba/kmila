<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model //Prestamo
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'note',
        'amount',
        'term_months',
        'interest_rate',
        'start_date',
        'status',
        // Solicitado, Aprobado, Desembolsado, En curso, Atrasado, En mora, Reestructurado, Pagado
        // Requested, Approved, Disbursed, In progress, Overdue, Delinquent, Restructured, Paid
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function capital()
    {
        return $this->hasMany('App\Models\Capital', 'finance_id');
    }

    public function obligations()
    {
        return $this->hasMany('App\Models\Obligation', 'finance_id');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payments', 'finance_id');
    }
}
