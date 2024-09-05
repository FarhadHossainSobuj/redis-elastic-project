<?php

namespace App\Http\Controllers;

use App\Jobs\TransferMoneyJob;
use Illuminate\Http\Request;

class TransferMoneyController extends Controller
{
    public function transfer()
    {
        return view('transfer');
    }

    public function transferStore(Request $request)
    {
        $request->validate([
            'amount' => "required"
        ]);

        // for ($i = 0; $i < 50; $i++) {
        //     if ($i % 3 == 0) {
        //         dispatch(new TransferMoneyJob($request->amount))->onQueue("high");
        //     } else {
        //         dispatch(new TransferMoneyJob($request->amount));
        //     }
        // }

        dispatch(new TransferMoneyJob($request->amount));

        dd($request->all());
    }
}
