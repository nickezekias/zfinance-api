<?php

namespace App\Http\Controllers;

use App\Http\Resources\CreditCardResource as ObjResource;
use App\Models\CreditCard as Obj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreditCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = DB::table('credit_cards')->where('user_id', Auth::user()->id)->get();
        return ObjResource::collection($all);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return response()->json(Auth::user()->id);
        $obj = Obj::firstOrCreate([
           'account_number' => $request->input('accountNumber'),
           'cvc' => $request->input('cvc'),
           'expiry_date' => $request->input('expiryDate'),
           'holder' => $request->input('holder'),
           'is_active' => true,
           'issuer' => $request->input('issuer'),
           'network' => $request->input('network'),
           'number' => $request->input('number'),
           'type' => $request->input('type'),
           'user_id' => Auth::user()->id,
           'created_at' => now(),
           'updated_at' => now()
        ]);

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
        $obj = Obj::findOrFail($id);
        $obj->account_number = $request->input('accountNumber');
        $obj->cvc = $request->input('cvc');
        $obj->expiry_date = $request->input('expiryDate');
        $obj->holder = $request->input('holder');
        $obj->issuer = $request->input('issuer');
        $obj->network = $request->input('network');
        $obj->number = $request->input('number');
        $obj->type = $request->input('type');
        $obj->save();
        $obj->refresh();
        return new ObjResource($obj);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Obj::findOrFail($id)->delete();
    }
}
