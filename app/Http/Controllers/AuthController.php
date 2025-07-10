<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login() {
        return view("login");
    }

    public function loginSubmit(Request $request) {
        //Form Validation:
        $request->validate(
            //Rules: 
            ["text_username" => "required|email", "text_password" => "required|min:6|max:16"],
            //Error Messages:
            [
                "text_username.required" => "O username é obrigatório!", "text_username.email" => "Username deve ser um email válido!",
                "text_password.required" => "A senha é obrigatória!", "text_password.min" => "A senha deve ter pelo menos :min caracteres!", "text_password.max" => "A senha deve ter no máximo :max caracteres!"
            ]
        );

        //Get User Input:
        $username = $request->input("text_username");
        $password = $request->input("text_password");
        
        //Check Users Exists:
        $user = User::where("username", $username)
                    ->where("deleted_at", NULL)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with("loginError", "Username ou password incorretos!");
        }

        //Check is Password is Correct:
        if (!password_verify($password, $user->password)) {
            return redirect()->back()->withInput()->with("loginError", "Username ou password incorretos!");
        }

        //Update Last Login:
        $user->last_login = date("Y-m-d H:i:s");
        $user->save();

        //Login User:
        session(["user" => ["id" => $user->id, "username" => $user->username]]);
                    
        echo "LOGIN COM SUCESSO!";
    }

    public function logout() {
        echo "Logout!";
    }
}
