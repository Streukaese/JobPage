<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;
use App\Models\Job;

// Homesite
// Route::get('/', function () {
    // // $jobs = Job::all();
    // // // Debugging bzw. genaue Datenwiedergabe (stack)
    // // dd($jobs[0]);

    // return view('home');
// });
// Way 3 - Same like Homesite->SeeTop - Route::view();
Route::view('/', 'home');

Route::controller(JobController::class)->group(function (){
    Route::get('/jobs', 'index');
    Route::get('/jobs/create', 'create');
    Route::get('/jobs/{job}', 'show');
    Route::post('/jobs', 'store');
    Route::get('/jobs/{job}/edit', 'edit');
    Route::patch('/jobs/{job}', 'update');
    Route::delete('/jobs/{id}', 'destroy');
});

// Index
Route::get('/jobs', [JobController::class, 'index']);

// Create
Route::get('/jobs/create', [JobController::class, 'create']);

// Show(Way1 - Route Model Binding)
Route::get('/jobs/{job}', [JobController::class, 'show']);
// // ShowBefore(Way1 - Route Model Binding)
// Route::get('/jobs/{job}', function (Job $job) {
    // return view('jobs.show', ['job' => $job]);
// });

// Store in DB
Route::post('/jobs', [JobController::class, 'store']);

// Edit 
Route::get('/jobs/{job}/edit', [JobController::class, 'edit']);

// Update Jobs - ("patch" and not "post" CAUSE "patch" knows to Update data | "post" need to choice between storying new $job in 'DB' or 'Updating' it (=='/jobs/{id}/update'))
Route::patch('/jobs/{job}', [JobController::class, 'update']);

// Destroy record in DB - ("delete" and not "post" CAUSE "delete" knows to Delete data | "post" = <See COMMENT @Top>)
Route::delete('/jobs/{id}', [JobController::class, 'destroy']);

// // Contact from job
// Route::get('/contact', function () {
    // return view('contact');
// });
// Way 3 - Same like Homesite->SeeTop - Route::view();
Route::view('/contact', 'contact');

Route::get('/test', function () {
    return view('test');
});