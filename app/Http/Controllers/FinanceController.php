<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Capital;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $finances = Finance::all();
        return response($finances,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'amount' => 'required',
            'interest_rate' => 'required',
            'start_date' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails()){
            $data = [
                'message'=> 'error',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data,400);
        }

        $available_capital = $this->summary();

        if($available_capital['total_disponible'] >= $request->amount){

            $finance = Finance::create([
                'user_id' => $request->user_id,
                'note' => $request->note,
                'amount' => $request->amount,
                'term_months' => $request->term_months,
                'interest_rate' => $request->interest_rate,
                'start_date' => $request->start_date,
                'status' => $request->status
            ]);

            if($finance->status == 'Aprobado'){
                $type = 'loan';
            }else{
                $type = 'requested';
            }

            Capital::create([
                'finance_id' => $finance->id,
                'amount' => $finance->amount,
                'with_partner' => false,
                'description' => 'Finance: '.$finance->note,
                'type' => $type,
                'status' => 'Active'
            ]);

        }else{

            $data = [
                'message'=> 'Error Capital no disponible',
                'status' => 500
            ];
            return response()->json($data,500);
        }


        if(!$finance){
            $data = [
                'message'=> 'error al crear el registro',
                'status' => 500
            ];
            return response()->json($data,500);
        }

        $data = [
            'status' => 201,
            'message' => 'Registro Creado.',
            'finance' => $finance,
        ];

        return response()->json($data,201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json(Finance::find($id),201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'user_id' => 'required',
            'amount' => 'required',
            'interest_rate' => 'required',
            'start_date' => 'required',
            'status' => 'required'
        ])->validate();

        $finance = Finance::find($id);
        $finance->update([
            'user_id' => $request->user_id,
            'note' => $request->note,
            'amount' => $request->amount,
            'term_months' => $request->term_months,
            'interest_rate' => $request->interest_rate,
            'start_date' => $request->start_date,
            'status' => $request->status
        ]);

        $capital = Capital::find($finance->capital->first()->id);
        if($finance->status == 'Aprobado'){
            $type = 'loan';
        }else{
            $type = 'requested';
        }

        $capital->update([
            'amount' => $finance->amount,
            'with_partner' => false,
            'description' => 'Finance: '.$finance->note,
            'type' => $type,
        ]);

        $data = [
            'status' => 201,
            'message' => 'Registro Actualizado.',
            'Finance' => $finance,
        ];

        return response()->json($data,201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $finance = Finance::find($id);
        $finance->update([
            'status' => 'Delete'
        ]);

        $data = [
            'status' => 201,
            'message' => 'Registro Eliminado.',
            'Finance' => $finance
        ];

        return response()->json($data,201);
    }

    public function search($select, $param)
    {
        $finance = Finance::where($select, 'like', '%'.$param.'%')->get();
        return response()->json($finance,201);
    }

    public function summary()
    {
        $capital = Capital::where('status', 'Active')->get();

        $totalIn = $capital->where('type', 'in')->sum('amount'); //inversion Total
        $totalOut = $capital->where('type', 'out')->sum('amount'); //salida de capital
        $loan = $capital->where('type', 'loan')->sum('amount'); // Capital Prestado
        $pay = $capital->where('type', 'pay')->sum('amount'); // pagos, intereses o capital

        $data = [
            'message' => 'Resumen Capital.',
            'capital_total' => $totalIn, //inversion Total
            'capital_salida_total' => $totalOut,
            'total_prestado' => $loan,
            'total_disponible' => ($totalIn - $totalOut - $loan) + $pay,
            'pagos_totales' => $pay
        ];
        return $data;
    }


    public function FinanceByRelations($id){

        $finance = Finance::find($id);

        $data = [
            'status' => 201,
            'message' => 'Finances by Relations.',
            'user' => $finance->user,
            'obligations' => $finance->obligations,
            'capital' => $finance->capital
        ];

        return response()->json($data,201);
    }

    public function createObligation($data){
        return true;
    }

}
