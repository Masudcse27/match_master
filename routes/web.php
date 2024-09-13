<?php

use App\Http\Controllers\auth\RegistrationController;
use App\Http\Controllers\groun\GroundController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MassageController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\MatchSquadsController;
use App\Http\Controllers\PlayerInfoController;
use App\Http\Controllers\ScoreboardController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamSquadsController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\UserFeedbackController;
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
Route::get('/logout',[LoginController::class,'logout'])->name('logout');
Route::get('/',[HomeController::class,'index'])->name('home');


route::get('/add-ground',[GroundController::class,'index'])->name('add_ground');
route::post('/add-ground',[GroundController::class,'create'])->name('add_ground');
Route::get('/show-ground/{id}', [GroundController::class, 'retrive'])->name('show.ground');
Route::put('/grounds/{id}', [GroundController::class, 'update'])->name('ground.update');


Route::get('/messages/{userId}', [MassageController::class, 'index'])->name('messages.index');
Route::get('/messagesfetch/{userId}', [MassageController::class, 'fetchMessages'])->name('messages.index');
Route::post('/messages', [MassageController::class, 'store'])->name('messages.store');

Route::get('/team-registration', [TeamController::class, 'index'])->name('team.registration');
Route::post('/team-registration', [TeamController::class, 'create'])->name('team.registration');

Route::get('/add-player-team/{id}', [TeamSquadsController::class,'index'])->name('add.player.team');
Route::post('/add-player-team/{id}', [TeamSquadsController::class,'create'])->name('add.player.team');
Route::get('/team-squads/{id}', [TeamSquadsController::class,'list'])->name('team.squads');
Route::delete('/team_squads/{id}', [MassageController::class, 'destroy'])->name('team_squads.destroy');

// Route::get('/player-info/{userid}', [PlayerInfoController::class, 'index'])->name('player.info');
Route::get('/player-profile/{id}', [PlayerInfoController::class, 'index'])->name('players.show');

Route::get('/create-tournament', [TournamentController::class,'index'])->name('tournaments.store');
Route::post('/create-tournament', [TournamentController::class,'store'])->name('tournaments.store');
Route::get('/tournaments', [TournamentController::class,'list'])->name('tournaments');
Route::get('/tournaments-join/{id}', [TournamentController::class,'join'])->name('tournaments.join');
Route::post('/tournaments-join/{id}', [TournamentController::class,'join_store'])->name('tournaments.join');

Route::get('/create-feature/{tournamentId}', [MatchesController::class, 'createFeature'])->name('create.feature');
Route::post('/save-matches/{tournamentId}', [MatchesController::class, 'saveMatches'])->name('save.matches');

Route::get('/select-players/{teamId}/{matchId}', [MatchSquadsController::class, 'showSelectPlayers'])->name('select.players');
Route::post('/save-players/{teamId}/{matchId}', [MatchSquadsController::class, 'savePlayers'])->name('save.players');


Route::get('/scoreboard/{matchId}', [ScoreboardController::class, 'showScoreboard'])->name('scoreboard.show');
Route::post('/update-player-status', [ScoreboardController::class, 'updatePlayerStatus'])->name('player.updateStatus');
Route::post('/update-bowling-status', [ScoreboardController::class, 'updateBowlingStatus'])->name('player.updateBowlingStatus');
Route::post('/complete-ball', [ScoreboardController::class, 'completeBall'])->name('ball.complete');

Route::post('/feedback', [UserFeedbackController::class,'store'])->name('user.feedback');
Route::get('/feedback', [UserFeedbackController::class,'index'])->name('user.feedback');