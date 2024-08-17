<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payments;
use App\Models\Obligation;
use App\Models\Capital;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payments::all();
        return response($payments,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'admin_user' => 'required',
            'finance_id' => 'required',
            'capital_amount' => 'required',
            'interest_amount' => 'required',
            'payment_date' => 'required',
            'note' => 'required',
            'support' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            $data = [
                'message'=> 'error',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data,400);
        }

        $obligation_init = Finance::find($request->finance_id)->obligations->first();

        $new_interest_pending = '';
        $new_capital_pending = '';


        $payments = Payments::create([
            'user_id' => $request->user_id,
            'admin_user' => $request->admin_user,
            'finance_id' => $request->finance_id,
            'capital_amount' => $request->capital_amount,
            'interest_amount' => $request->interest_amount,
            'payment_date' => $request->payment_date,
            'total_amount' => $request->capital_amount + $request->interest_amount,
            'note' => $request->note,
            'support' => $request->support,
            'status' => $request->status
        ]);

        if($payments->capital_amount != 0){
            Capital::create([
                'amount' => $payments->capital_amount,
                'with_partner' => false,
                'description' => 'Pago: '. $payments->note . ' - User: '. $payments->user->name,
                'type' => "capital_pay",
                'status' => 'Active'
            ]);

            $new_capital_pending = $obligation_init->capital_pending - $payments->capital_amount;
        }

        if($payments->interest_amount != 0){
            Capital::create([
                'amount' => $payments->interest_amount,
                'with_partner' => false,
                'description' => 'Pago: '. $payments->note . ' - User: '. $payments->user->name,
                'type' => "interest_pay",
                'status' => 'Active'
            ]);

            if($obligation_init->interest_pending != 0 ){
                $new_interest_pending = $obligation_init->interest_pending - $payments->interest_amount;
            }
        }else{

            $new_interest_pending = $obligation_init->interest_pending + ($obligation_init->capital_pending / 100) * $obligation_init->finances->interest_rate;

        }

        if(!$payments){
            $data = [
                'message'=> 'Error al crear el registro',
                'status' => 500
            ];
            return response()->json($data,500);
        }

        if($new_capital_pending >= 0){
            $obligation_init->update([
                'capital_pending' => $new_capital_pending,
                'last_update_date' => Carbon::now(),
            ]);
        }

        if($new_interest_pending >= 0){
            $obligation_init->update([
                'interest_pending' => $new_interest_pending,
                'last_update_date' => Carbon::now(),
            ]);
        }

        $data = [
            'status' => 201,
            'message' => 'Registro Creado.',
            'payments' => $payments,
        ];

        return response()->json($data,201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json(Payments::find($id),201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'capital_amount' => 'required',
            'interest_amount' => 'required',
            'payment_date' => 'required',
            'note' => 'required',
            'support' => 'required',
            'status' => 'required',
        ])->validate();

        $payments = Payments::find($id);
        $payments->update([
            'capital_amount' => $request->capital_amount,
            'interest_amount' => $request->interest_amount,
            'payment_date' => $request->payment_date,
            'total_amount' => $request->capital_amount + $request->interest_amount,
            'note' => $request->note,
            'support' => $request->support,
            'status' => $request->status
        ]);

        $data = [
            'status' => 201,
            'message' => 'Registro Actualizado.',
            'payments' => $payments
        ];

        return response()->json($data,201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $payments = Payments::find($id);
        $payments->update([
            'status' => 'Delete'
        ]);

        $data = [
            'status' => 201,
            'message' => 'Registro Eliminado.',
            'obligation' => $payments
        ];

        return response()->json($data,201);
    }

    public function search($select, $param)
    {
        $payments = Payments::where($select, 'like', '%'.$param.'%')->get();
        return response()->json($payments,201);
    }

    public function paymentsByRelations($id){

        $payments = Payments::find($id);
        $data = [
            'status' => 201,
            'message' => 'Obligation by Relations.',
            'user' => $payments->user,
            'userAdmin' => $payments->userAdmin,
            'finances' => $payments->finances
        ];

        return response()->json($data,201);
    }
}
