<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function change($locale, Request $request)
    {
        Session::put('language', $locale);

        return redirect()->back();
    }
}
