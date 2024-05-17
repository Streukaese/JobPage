<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Jobs\TranslationJob;
use App\Models\Job;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::view('/contact', 'contact');
Route::get('test', function () {        // Alternativ _--_ Route::view('/test', 'test');
    $job = Job::first();
    TranslationJob::dispatch($job);

    return 'Done';
}); 

// Route::get('test', function () { // zum testen des Emailservices
    // \Illuminate\Support\Facades\Mail::to('bleeseds@gmail.com')->send(   // return new \App\Mail\JobPosted(); -- To Test the view ob JobPosted(job-posted-blade.php)
        // new \App\Mail\JobPosted()
    // );

    // return 'Done';
    // });

                                            // ->middleware('auth') = erspart code in "jobcontroller", Authentifizierung muss nicht in jede Funktion
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/create', [JobController::class, 'create']);
Route::post('/jobs', [JobController::class, 'store'])->middleware('auth');
Route::get('/jobs/{job}', [JobController::class, 'show']);                     
                                                                 // ->middleware(['auth', 'can:edit-job,job']); == first you need permission to sign in, second permission to edit job
Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])
    ->middleware('auth')
    ->can('edit', 'job');   
                            // only edit after make:policy // ToDo - Route rules declaration

Route::patch('/jobs/{job}', [JobController::class, 'update']);
Route::delete('/jobs/{job}', [JobController::class, 'destroy']);

// Auth
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

// Tip 6 : Group the Routes with the JobController || PREFERED
/*
Route::resource('jobs', JobController::class, [
    'except' => ['edit'],   // Example to cut out sites from the "JobController"
    'only' => ['index', 'show', 'delete', 'update']    // Example to visit ONLY sites from "JobController" inside the Array[]
]);
*/

// -------------------------- Tip 6 at Top (Prefered and shortest Way) == @Word_Dokumentation ----------------------------------------