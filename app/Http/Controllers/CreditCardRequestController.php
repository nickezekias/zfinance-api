<?php

namespace App\Http\Controllers;

use App\Http\Resources\CreditCardRequestResource as ObjResource;
use App\Models\CreditCardRequest as Obj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreditCardRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = DB::table('credit_card_request')->where('user_id', Auth::user()->id)->get();
        return ObjResource::collection($all);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $obj = new Obj();
        $obj->user_id = Auth::user()->id;
        $obj->card_type = $request->input('cardType');
        $obj->card_network = $request->input('cardNetwork');
        $obj->card_issuer = $request->input('cardIssuer');
        $obj->save();

        return new ObjResource($obj);
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
