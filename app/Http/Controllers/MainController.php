<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index($value) {
        return view("main", ["value" => $value]);
    }

    public function page02($value) {
        return view("page02", ["value" => $value]);
    }

    public function page03($value) {
        return view("page03", ["value" => $value]);
    }
}
