<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index() {
        //Load User's Notes:

        //Show Home View:
        return view("home");
    }

    public function newNote() {
        echo "I'm creating a new note!";
    }
}
