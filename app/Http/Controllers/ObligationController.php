<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Capital;
use App\Models\Finance;
use App\Models\Obligation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObligationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obligation = Obligation::all();
        return response($obligation,200);
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
            'capital_pending' => 'required',
            'interest_pending' => 'required',
            'last_update_date' => 'required',
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

        $obligation = Obligation::create([
            'user_id' => $request->user_id,
            'admin_user' => $request->admin_user,
            'finance_id' => $request->finance_id,
            'capital_pending' => $request->capital_pending,
            'interest_pending' => $request->interest_pending,
            'last_update_date' => $request->last_update_date,
            'note' => $request->note,
            'status' => $request->status
        ]);



        if(!$obligation){
            $data = [
                'message'=> 'Error al crear el registro',
                'status' => 500
            ];
            return response()->json($data,500);
        }

        $data = [
            'status' => 201,
            'message' => 'Registro Creado.',
            'obligation' => $obligation,
        ];

        return response()->json($data,201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json(Obligation::find($id),201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'capital_pending' => 'required',
            'interest_pending' => 'required',
            'last_update_date' => 'required',
            'status' => 'required',
        ])->validate();

        $obligation = Obligation::find($id);
        $obligation->update([
            'capital_pending' => $request->capital_pending,
            'interest_pending' => $request->interest_pending,
            'last_update_date' => $request->last_update_date,
            'note' => $request->note,
            'status' => $request->status
        ]);

        $data = [
            'status' => 201,
            'message' => 'Registro Actualizado.',
            'obligation' => $obligation
        ];

        return response()->json($data,201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $obligation = Obligation::find($id);
        $obligation->update([
            'status' => 'Delete'
        ]);

        $data = [
            'status' => 201,
            'message' => 'Registro Eliminado.',
            'obligation' => $obligation
        ];

        return response()->json($data,201);
    }

    public function search($select, $param)
    {
        $obligation = Obligation::where($select, 'like', '%'.$param.'%')->get();
        return response()->json($obligation,201);
    }

    public function obligationByRelations($id){

        $obligation = Obligation::find($id);
        $data = [
            'status' => 201,
            'message' => 'Obligation by Relations.',
            'user' => $obligation->user,
            'userAdmin' => $obligation->userAdmin,
            'finances' => $obligation->finances
        ];

        return response()->json($data,201);
    }
}
