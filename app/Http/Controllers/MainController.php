<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
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
        //Show new Note View:
        return view("new_note");
    }

    public function newNoteSubmit(Request $request) {
        //Validate Request:
        $request->validate(
            //Rules: 
            ["text_title" => "required|min:3|max:200", "text_note" => "required|min:3|max:3000"],
            //Error Messages:
            [
                "text_title.required" => "O título é obrigatório!", "text_title.min" => "O título deve ter pelo menos :min caracteres!", "text_title.max" => "O título deve ter no máximo :max caracteres!",
                "text_note.required" => "A nota é obrigatória!", "text_note.min" => "A nota deve ter pelo menos :min caracteres!", "text_note.max" => "A nota deve ter no máximo :max caracteres!"
            ]
        );
        
        //Get User id:
        $id = session("user.id");

        //Create new Note:
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        //Redirect to Home:
        return redirect()->route("home");
    }

    public function editNote($id) {
        
        $id = Operations::decryptId($id);

        echo "I'm editing note with id = $id";
    }

    public function deleteNote($id) {
        
        $id = Operations::decryptId($id);

        echo "I'm deleting note with id = $id";
    }
}
