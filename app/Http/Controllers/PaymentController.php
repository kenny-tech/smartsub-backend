<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = auth()->user()->payments;

        return response()->json([
            'success' => true,
            'data' => $payments
        ]);
    }
}
