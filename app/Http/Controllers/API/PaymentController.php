<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

class PaymentController extends BaseController
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
