<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function getServices()
    {
        $services = Service::get();

        return response()->json($services, 200);
    }
}
