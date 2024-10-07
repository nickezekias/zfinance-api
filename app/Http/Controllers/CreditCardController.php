<?php

namespace App\Http\Controllers;

use App\Http\Resources\CreditCardResource as ObjResource;
use App\Models\CreditCard as Obj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;

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

    /**
     * Transfer money to another credit card
     */
    public function transferMoney(Request $request, TransactionController $tc)
    {
        //TODO: check pass code

        $recipient_cc_number = $request->input('recipientCardNumber');
        $amount = $request->input('amount');

        // $recipient_cc = DB::table('credit_cards')->where('number', '=', $recipient_cc_number)->first();
        $recipient_cc = Obj::where('number', '=', $recipient_cc_number)->first();
        $sender_cc = Obj::where('user_id', '=', Auth::user()->id)->first();
        if ($recipient_cc && $sender_cc) {
            if (!$sender_cc->is_valid()) {
                return response()->json(['features.cc.yourCCIsExpiredOrDeactivated'], 401);
            }
            if (!$recipient_cc->is_valid()) {
                return response()->json(['features.cc.recipientCCIsExpiredOrDeactivated'], 401);
            }

            //TODO: Use DB transaction for these operations
            //TODO: check sender has sufficient funds
            if ($sender_cc->has_sufficient_funds($amount)) {
                //increase recipient cc amount
                $recipient_cc->amount += $amount;
                $recipient_cc->updated_at = now();
                $recipient_cc->save();

                // decrease sender cc amount
                $sender_cc->amount -= $amount;
                $sender_cc->updated_at = now();
                $sender_cc->save();

                $trans_input = [
                    'amount' => $amount,
                    'beneficiary' => $recipient_cc->holder,
                    'description' =>  'features.cc.moneyTransferRequestDescription',
                    'title' =>  'labels.moneyTransfer',
                    'type' => Transaction::TRANS_TYPE_EXPENSE
                ];
                $tc->store($trans_input);

                return response()->json([], 200);
            } else {
                return response()->json(['features.cc.insufficientFunds'], 401);
            }
        } else {
            return response()->json(['features.cc.invalidData'], 404);
        }
    }

    /**
     * Recharge credit card
     */
    public function rechargeCard(Request $request, TransactionController $tc)
    {
        //TODO: check pass code

        //TODO: Use DB transaction for these operations
        $cc = Obj::where('user_id', '=', Auth::user()->id)->first();
        if ($cc) {
            $cc->amount += $request->input('amount');
            $cc->save();
            $trans_input = [
                'amount' => $request->input('amount'),
                'beneficiary' => Auth::user()->last_name . ' ' . Auth::user()->first_name,
                'description' =>  'features.cc.cardRechargeRequestDescription',
                'title' => 'labels.cardRecharge',
                'type' => Transaction::TRANS_TYPE_ENTRY
            ];
            $tc->store($trans_input);
            return response()->json([], 200);
        } else {
            return response()->json(['features.cc.invalidData'], 404);
        }
    }
}
