<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", function () {
    if(Auth::check()) {
        return redirect()->to('/profile/edit');
    }
    return view("login");
})->name('login');

Route::get("/registration", function () {
    return view("profile-registration");
});

Route::post("/profile/create", [ProfileController::class, "create"]);
Route::post("/profile/login", [ProfileController::class, "login"]);

Route::group(["middleware" => ["auth"]], function () {
    Route::get("/profile/edit", function () {
        return view("profile-edit");
    });
    Route::get("/profile", [ProfileController::class, "profileDetails"]);
    Route::put("/profile", [ProfileController::class, "updateProfile"]);
    Route::get("/profile/logout", [ProfileController::class, "logout"]);
});
