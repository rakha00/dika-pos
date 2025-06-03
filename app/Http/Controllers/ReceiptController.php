<?php

namespace App\Http\Controllers;


use App\Models\Transaction;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function printReceipt(Request $request)
    {
        $transaction = Transaction::with('detailTransactions.menu.customOptions.customOption')->findOrFail($request->transactionId);
        return view('components.history.receipt', compact('transaction'));
    }
}
