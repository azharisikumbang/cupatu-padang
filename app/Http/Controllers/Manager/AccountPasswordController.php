<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountPasswordController extends Controller
{
    public function edit(Request $request)
    {
        return view("manager.account-password.index");
    }
}