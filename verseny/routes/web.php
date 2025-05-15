<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::get('/login', function() {
    return view('welcome');
});

Auth::routes([
    'register' => false,
]);
Route::get('/felhasznalok', [App\Http\Controllers\UserController::class, 'list'])->name('users.list')->middleware();
Route::post('/felhasznalo/update', [App\Http\Controllers\UserController::class, 'update'])->name('users.update')->middleware(\App\Http\Middleware\AjaxRequest::class);
Route::post('/felhasznalo/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('users.delete');
Route::post('/felhasznalo/{userId}', [App\Http\Controllers\UserController::class, 'showDetails'])->name('users.showDetails')->middleware();


Route::get('/versenyek/get/{verseny}', [App\Http\Controllers\HomeController::class, 'show'])->name('verseny.show')->middleware(\App\Http\Middleware\AjaxRequest::class);
Route::get('/versenyek/showall', [App\Http\Controllers\HomeController::class, 'list'])->name('verseny.list');

Route::get('/versenyek/listParticipant', [App\Http\Controllers\HomeController::class, 'listParticipant'])->name('verseny.listParticipant');
Route::get('/versenyek/listLanguages/{verseny}', [App\Http\Controllers\HomeController::class, 'listLanguages'])->name('verseny.listLanguages');
Route::get('/versenyek/delete/{verseny}', [App\Http\Controllers\HomeController::class, 'delete'])->name('verseny.delete');
Route::post('/versenyek/edit/', [App\Http\Controllers\HomeController::class, 'edit'])->name('verseny.edit');
Route::post('/versenyek/store', [App\Http\Controllers\HomeController::class, 'store'])->name('verseny.store');
Route::post('/versenyek/participant', [App\Http\Controllers\HomeController::class, 'addRemoveParticipant'])->name('verseny.addRemoveParticipant');
//TODO: languages
Route::post('/versenyek/languages/add', [App\Http\Controllers\HomeController::class, 'addLanguagetoVerseny'])->name('verseny.addLanguage');
Route::post('/versenyek/languages/remove', [App\Http\Controllers\HomeController::class, 'removeLanguagefromVerseny'])->name('verseny.RemoveLanguage');

Route::post('/versenyek/addRound', [App\Http\Controllers\HomeController::class, 'addRound'])->name('verseny.addRound');
Route::post('/versenyek/removeRound', [App\Http\Controllers\HomeController::class, 'removeRound'])->name('verseny.removeRound');


