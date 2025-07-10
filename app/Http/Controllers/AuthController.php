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
        
        //Get all the Users from the Database:
        //$users = User::all()->toArray();
        $userModel = new User();
        $users = $userModel->all()->toArray();

        echo "<pre>";
        print_r($users);
    }

    public function logout() {
        echo "Logout!";
    }
}
