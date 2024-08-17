<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model //Cuotas
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_user',
        'finance_id',
        'payment_date',
        'capital_amount',
        'interest_amount',
        'total_amount',
        'note',
        'support',
        'status',
        // Pendiente, Pagado, Vencido,
        // Pending, Paid, Overdue
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
