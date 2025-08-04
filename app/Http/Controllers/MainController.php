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
        $notes = User::find($id)->notes()->whereNull("deleted_at")->get()->toArray();

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

        //Load Note:
        $note = Note::find($id);

        //Show Edit Note View:
        return view("edit_note", ["note" => $note]);
    }

    public function editNoteSubmit(Request $request) {
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

        //Check if note_id Exists:
        if ($request->note_id == null) {
            return redirect()->route("home");
        }

        //Decrypt note_id:
        $id = Operations::decryptId($request->note_id);

        //Load Note:
        $note = Note::find($id);

        //Update Note:
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        //Redirect to Home:
        return redirect()->route("home");
    }

    public function deleteNote($id) {
        
        $id = Operations::decryptId($id);

        //Load Note:
        $note = Note::find($id);

        //Show Delete Note Confirmation:
        return view("delete_note", ["note" => $note]);
    }

    public function deleteNoteConfirm($id) {
        //Check if $id is Encrypted:
        $id = Operations::decryptId($id);

        //Load Note:
        $note = Note::find($id);

        //1. Hard Delete:
        //$note->delete();

        //2. Soft Delete:
        //$note->deleted_at = date("Y-m-d H:i:s");
        //$note->save();

        //3. Soft Delete (Property SoftDeletes in Model):
        $note->delete();

        //4. Hard Delete (Property SoftDeletes in Model):
        //$note->forceDelete();

        //Redirect to Home:
        return redirect()->route("home");
    }
}
