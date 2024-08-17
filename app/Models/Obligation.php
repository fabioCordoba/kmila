<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obligation extends Model //Deuda
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_user',
        'finance_id',
        'capital_pending',
        'interest_pending',
        'last_update_date',
        'note',
        'status',
        // Pendiente, Atrasada, En mora, Pagada, Reestructurada
        // Pending, Overdue, Delinquent, Paid, Restructured
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function userAdmin()
    {
        return $this->belongsTo('App\Models\User', 'admin_user');
    }

    public function finances()
    {
        return $this->belongsTo('App\Models\Finance', 'finance_id');
    }
}
