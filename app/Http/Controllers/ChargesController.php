<?php

namespace App\Http\Controllers;

use App\OrderFee;
use Illuminate\Http\Request;

class ChargesController extends Controller
{
    public function getCharges()
    {
        $chgs = OrderFee::orderBy('id', 'ASC')->get();

        return response()->json($chgs, 200);
    }
}
