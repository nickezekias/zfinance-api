<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Transaction as Obj;
use App\Http\Resources\TransactionResource as ObjResource;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = DB::table('transactions')->where('user_id', Auth::user()->id)->get();
        return ObjResource::collection($all);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(array $input)
    {
        $obj = new Obj();
        $obj->amount = $input['amount'];
        $obj->beneficiary = $input['beneficiary'];
        $obj->date = now();
        $obj->description = $input['description'];
        $obj->type = $input['type'];
        $obj->user_id = Auth::user()->id;
        $obj->save();

        // return new ObjResource($obj);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new ObjResource(Obj::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Obj::findOrFail($id)->delete();
    }
}
