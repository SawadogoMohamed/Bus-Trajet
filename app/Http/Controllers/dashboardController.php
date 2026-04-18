<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function accueil()
    {
        return view('dashboards.accueil');
    }
}
