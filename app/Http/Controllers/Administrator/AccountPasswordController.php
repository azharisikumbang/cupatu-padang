<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountPasswordController extends Controller
{
    public function edit(Request $request)
    {
        return view("administrator.account-password.index");
    }
}