<?php

use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\auth\RegistrationController;
use App\Http\Controllers\ClubManagerController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\groun\GroundAuthorityProfileController;
use App\Http\Controllers\groun\GroundController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MassageController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\MatchPredictionController;
use App\Http\Controllers\MatchSquadsController;
use App\Http\Controllers\PlayerInfoController;
use App\Http\Controllers\ScoreboardController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamManagerProfile;
use App\Http\Controllers\TeamSquadsController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\UserFeedbackController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;



Route::group(['middleware'=>'login'],function(){
    Route::get('/login',[LoginController::class,'index'])->name('login');
    Route::post('/login',[LoginController::class,'authenticate'])->name('login');
    Route::get('/registration',[RegistrationController::class,'index_manager'])->name('managers.reagistration');
    Route::post('/registration',[RegistrationController::class,'manager_register'])->name('managers.reagistration');
    Route::get('/admin-panel-registration',[RegistrationController::class,'index_admin_panel'])->name('admin_panel.reagistration');
    Route::post('/admin-panel-registration',[RegistrationController::class,'admin_panel_register'])->name('admin_panel.reagistration');
});

Route::get('/player-registration/{team_id}',[RegistrationController::class,'index_player'])->name('player.reagistration');
Route::post('/player-registration/{team_id}',[RegistrationController::class,'player_register'])->name('player.reagistration');

Route::get('/logout',[LoginController::class,'logout'])->name('logout');
Route::get('/',[HomeController::class,'index'])->name('home');

Route::group(['prefix'=> 'player'], function () {
    Route::group(['middleware'=>'auth'], function () {
        Route::get('/player-profile', [PlayerInfoController::class, 'index'])->name('player.profile');
        Route::put('/player-profile-update', [PlayerInfoController::class, 'update'])->name('player.profile.update');
    });
});

Route::get('/team-manager-profile',[TeamManagerProfile::class,'index'])->name('team.manager.profile');

Route::get('/match-details/{match_id}/{team_id}',[MatchesController::class,'details'])->name('match.details');


#team
Route::delete('/team/{team_id}/player/{player_id}/remove', [TeamSquadsController::class, 'remove'])->name('team.squad.remove');
Route::post('/add-player-team/{team_id}', [TeamSquadsController::class,'create'])->name('add.player.team');
Route::get('/team-registration', [TeamController::class, 'index'])->name('team.registration');
Route::post('/team-registration', [TeamController::class, 'create'])->name('team.registration');
Route::get('/team-details/{id}',[TeamController::class,'details'])->name('team.details');

Route::get('/ground-authority-profile',[GroundAuthorityProfileController::class,'index'])->name('ground.authority.profile');
Route::get('/ground-bookings/{id}',[GroundController::class,'index'])->name('ground.bookings');
Route::get('/add-ground',[GroundController::class,'index'])->name('add_ground');
Route::post('/add-ground',[GroundController::class,'create'])->name('add_ground');
Route::get('/show-ground/{id}', [GroundController::class, 'retrive'])->name('show.ground');
Route::put('/grounds/{id}', [GroundController::class, 'update'])->name('ground.update');


Route::get('/messages/{userId}', [MassageController::class, 'index'])->name('messages.index');
Route::get('/messages-fetch/{userId}', [MassageController::class, 'fetchMessages'])->name('messages.fetch');
Route::post('/messages', [MassageController::class, 'store'])->name('messages.store');



Route::get('/add-player-team/{id}', [TeamSquadsController::class,'index'])->name('add.player.team');
Route::get('/team-squads/{id}', [TeamSquadsController::class,'list'])->name('team.squads');
Route::delete('/team_squads/{id}', [MassageController::class, 'destroy'])->name('team_squads.destroy');

Route::get('/player-info/{userid}', [PlayerInfoController::class, 'show'])->name('player.info');


Route::get('/create-tournament', [TournamentController::class,'index'])->name('tournaments.store');
Route::post('/create-tournament', [TournamentController::class,'store'])->name('tournaments.store');
Route::get('/tournaments', [TournamentController::class,'list'])->name('tournaments');
Route::get('/tournaments-join/{id}/{teamId}', [TournamentController::class,'join'])->name('tournaments.join');
Route::get('tournament-mange/{id}',[TournamentController::class,'manage_tournament'])->name('tournament.manage');
Route::post('set-date-match/{id}',[TournamentController::class,'set_date'])->name('set.date');
Route::post('add-team/{id}',[TournamentController::class,'add_team'])->name('add.team');
Route::get('/tournament-details/{id}/{teamId}',[TournamentController::class,'details'])->name('tournament.details');

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
Route::get('/show-feedback',[UserFeedbackController::class,'list'])->name('show.feedback');
Route::delete('/delete-feedback/{id}',[UserFeedbackController::class,'delete'])->name('delete.feedback');

Route::post('/friendly-match-request/{id}', [MatchesController::class,'create_friendly_match'])->name('friendly.match.request');
Route::get('/friendly-match-request-accept/{id}', [MatchesController::class,'accept_friendly_match_request'])->name('friendly.match.request.accept');
Route::get('/friendly-match-request-reject/{id}', [MatchesController::class,'reject_friendly_match_request'])->name('friendly.match.request.reject');

Route::get('/otp-verification',[EmailVerificationController::class,'index'])->name('otp.verification');
Route::post('/otp-verification',[EmailVerificationController::class,'verify_email'])->name('otp.verification');
Route::get('/otp-resend',[EmailVerificationController::class,'resend_code'])->name('otp.resend');

Route::get('/match-prediction/{id}',[MatchPredictionController::class,'index'])->name('match.prediction');
Route::post('/match-prediction/{id}',[MatchPredictionController::class,'store'])->name('match.prediction');


Route::get('/match-score/{match_id}',[HomeController::class ,'show_score'])->name("score");


Route::get('admin-profile',[AdminProfileController::class,'index'])->name('admin.profile');

Route::get('club-manager-profile',[ClubManagerController::class,'index'])->name('club.manager.profile');

Route::get('/all-team',[TeamController::class,'show_all_team'])->name('all.team');
Route::get('/all-bookings/{id}',[GroundAuthorityProfileController::class,'all_booking'])->name('all.booking');

// Route::get('/match/{matchId}/set-batting-team', [YourController::class, 'showSetBattingTeamForm'])->name('set_batting_team_form');
Route::post('/match/{matchId}/set-batting-team', [ScoreboardController::class, 'set_batting_team'])->name('set_batting_team');
Route::get('/innings-complete/{id}',[ScoreboardController::class,'complete_in'])->name('innings.complete');
Route::get('/match-end/{id}',[ScoreboardController::class,'match_end'])->name('match.end');