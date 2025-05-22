<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientProfileController extends Controller
{
    public function show()
    {
        $client = auth()->guard('client')->user();
        return view('clients.profile.show', compact('client'));
    }
}
