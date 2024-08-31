<?php

use App\Http\Controllers\auth\RegistrationController;
use App\Http\Controllers\groun\GroundController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MassageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;



Route::get('/login',[LoginController::class,'index']);
Route::post('/login',[LoginController::class,'authenticate'])->name('login');
Route::get('/registration',[RegistrationController::class,'index_manager'])->name('managers.reagistration');
Route::post('/registration',[RegistrationController::class,'manager_register'])->name('managers.reagistration');
Route::get('/player-registration',[RegistrationController::class,'index_player'])->name('player.reagistration');
Route::post('/player-registration',[RegistrationController::class,'player_register'])->name('player.reagistration');
Route::get('/admin-panel-registration',[RegistrationController::class,'index_admin_panel'])->name('admin_panel.reagistration');
Route::post('/admin-panel-registration',[RegistrationController::class,'admin_panel_register'])->name('admin_panel.reagistration');
Route::get('/',[HomeController::class,'index'])->name('home');
route::get('/add-ground',[GroundController::class,'index'])->name('add_ground');
route::post('/add-ground',[GroundController::class,'create'])->name('add_ground');

Route::get('/messages/{userId}', [MassageController::class, 'index'])->name('messages.index');
Route::get('/messagesfetch/{userId}', [MassageController::class, 'fetchMessages'])->name('messages.index');
Route::post('/messages', [MassageController::class, 'store'])->name('messages.store');
