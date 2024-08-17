<?php

namespace App\Http\Controllers;

use App\Models\Capital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CapitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $capitals = Capital::all();
        return response($capitals,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'description' => 'required',
            'with_partner' => 'required',
            'type' => 'required'
        ]);

        if($validator->fails()){
            $data = [
                'message'=> 'error',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data,400);
        }

        $capital = Capital::create([
            'amount' => $request->amount,
            'with_partner' => $request->with_partner,
            'description' => $request->description,
            'type' => $request->type,
            'status' => 'Active'
        ]);

        if(!$capital){
            $data = [
                'message'=> 'error al crear el registro',
                'status' => 500
            ];
            return response()->json($data,500);
        }

        $data = [
            'status' => 201,
            'message' => 'Registro Creado.',
            'capital' => $capital
        ];

        return response()->json($data,201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json(Capital::find($id),201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'amount' => 'required',
            'description' => 'required',
            'with_partner' => 'required',
            'type' => 'required'
        ])->validate();

        $capital = Capital::find($id);
        $capital->update([
            'amount' => $request->amount,
            'with_partner' => $request->with_partner,
            'description' => $request->description,
            'type' => $request->type,
            'status' => 'Active'
        ]);

        $data = [
            'status' => 201,
            'message' => 'Registro Actualizado.',
            'capital' => $capital
        ];

        return response()->json($data,201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $capital = Capital::find($id);
        $capital->update([
            'status' => 'Delete'
        ]);

        $data = [
            'status' => 201,
            'message' => 'Registro Eliminado.',
            'capital' => $capital
        ];

        return response()->json($data,201);
    }

    public function search($select, $param)
    {
        $capital = Capital::where($select, 'like', '%'.$param.'%')->get();
        return response()->json($capital,201);
    }

    public function summary()
    {
        $capital = Capital::where('status', 'Active')->get();

        $total_in = $capital->where('type', 'in')->sum('amount'); //inversion Total
        $total_out = $capital->where('type', 'out')->sum('amount'); //salida de capital
        $loan = $capital->where('type', 'loan')->sum('amount'); // Capital Prestado
        $capital_pay = $capital->where('type', 'capital_pay')->sum('amount'); // pagos capital
        $interest_pay = $capital->where('type', 'interest_pay')->sum('amount'); // pagos intereses
        $total_pay = $capital_pay + $interest_pay;
        $capital_total = $total_in + $total_pay;
        $requested = $capital->where('type', 'requested')->sum('amount');// solicitudes de prestamo

        //**crear otro estado para separar los pagos a intereses y los pagos a Capital */

        $data = [
            'status' => 200,
            'message' => 'Resumen Capital.',
            'capital_in' => $total_in, //inversion Total
            'capital_pay' => $capital_pay, //pagos capital
            'interest_pay' => $interest_pay, //pagos intereses
            'capital_total' => $capital_total, //inversion Total + pagos
            'pagos_totales' => $total_pay,
            'capital_salida_total' => $total_out,
            'total_prestado' => $loan - $capital_pay,
            'total_disponible' => ($capital_total - $total_out - $loan),
            'Solicitud_prestamo' => $requested
        ];
        return response()->json($data,200);
    }


}
