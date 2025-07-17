<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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

    public function editNote($id) {
        try {
            
            $id = Crypt::decrypt($id);
            
        } catch (DecryptException $e) {
            return redirect()->route("home");
        }

        echo "I'm editing note with id = $id";
    }

    public function deleteNote($id) {
        try {
            
            $id = Crypt::decrypt($id);
            
        } catch (DecryptException $e) {
            return redirect()->route("home");
        }

        echo "I'm deleting note with id = $id";
    }
}
