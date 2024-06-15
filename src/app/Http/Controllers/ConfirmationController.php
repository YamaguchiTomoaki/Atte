<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfirmationController extends Controller
{
    //コンストラクタ
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function confirmation()
    {
        return view('auth.confirmation');
    }
}
