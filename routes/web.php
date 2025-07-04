<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    echo "Hello World!";
});

Route::get("/about", function(){
    echo "About Us:";
});

Route::get("/main/{value}", [MainController::class, "index"]);
Route::get("/page02/{value}", [MainController::class, "page02"]);
Route::get("/page03/{value}", [MainController::class, "page03"]);