<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RapportController extends Controller
{
    public function index()
    {
        return view('rapports.index'); // Crée aussi la vue resources/views/rapports/index.blade.php
    }
}
