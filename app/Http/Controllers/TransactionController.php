<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Transaction as Obj;
use App\Http\Resources\TransactionResource as ObjResource;
use App\Models\Transaction;
use App\Notifications\CardRechargeRequestedNotification;
use App\Notifications\MoneyTransferRequestedNotification;
use Illuminate\Support\Facades\Notification;

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
        $obj->title = $input['title'];
        $obj->type = $input['type'];
        $obj->user_id = Auth::user()->id;
        $obj->save();

        if ($obj->type == Transaction::TRANS_TYPE_EXPENSE) {
            Notification::send([Auth::user()], new MoneyTransferRequestedNotification($obj));
        } else {
            Notification::send([Auth::user()], new CardRechargeRequestedNotification($obj));
        }
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
