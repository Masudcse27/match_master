<?php

use App\Http\Controllers\auth\RegistrationController;
use App\Http\Controllers\groun\GroundController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;



Route::get('/login',[LoginController::class,'index']);
Route::post('/login',[LoginController::class,'authenticate'])->name('login');
Route::get('/registration',[RegistrationController::class,'index_manager'])->name('managers.reagistration');
Route::post('/registration',[RegistrationController::class,'manager_register'])->name('managers.reagistration');
Route::get('/',[HomeController::class,'index'])->name('home');
route::get('/add-ground',[GroundController::class,'index'])->name('add_ground');
route::post('/add-ground',[GroundController::class,'create'])->name('add_ground');
