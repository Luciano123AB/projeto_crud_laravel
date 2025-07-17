<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index() {
        
        //Load User's Notes:
        $id = session("user.id");
        $notes = User::find($id)->notes()->get()->toArray();

        //Show Home View:
        return view("home", ["notes" => $notes]);
    }

    public function newNote() {
        echo "I'm creating a new note!";
    }
}
