<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::view('/contact', 'contact');
Route::view('/test', 'test');

// Route::get('test', function () { // zum testen des Emailservices
    // \Illuminate\Support\Facades\Mail::to('bleeseds@gmail.com')->send(   // return new \App\Mail\JobPosted(); -- To Test the view ob JobPosted(job-posted-blade.php)
        // new \App\Mail\JobPosted()
    // );

    // return 'Done';
    // });

                                            // ->middleware('auth') = erspart code in "jobcontroller", Authentifizierung muss nicht in jede Funktion
// Route::resource('jobs', JobController::class)->only(['index', 'show']);
// Route::resource('jobs', JobController::class)->except(['index', 'show'])->middleware('auth'); // same like bottom
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

// -------------------------- Tip 6 at Top (Prefered and shortest Way) ----------------------------------------

// Route::view('/', 'home');

// Route::controller(JobController::class)->group(function (){
    // Route::get('/jobs', 'index');
    // Route::get('/jobs/create', 'create');
    // Route::get('/jobs/{job}', 'show');
    // Route::post('/jobs', 'store');
    // Route::get('/jobs/{job}/edit', 'edit');
    // Route::patch('/jobs/{job}', 'update');
    // Route::delete('/jobs/{id}', 'destroy');
// });

// Route::view('/contact', 'contact');

// ---------------------------------- Bottom is Documentation of the way to the top ----------------------------------------------------

// // Homesite
// Route::get('/', function () {
    // // $jobs = Job::all();
    // // // Debugging bzw. genaue Datenwiedergabe (stack)
    // // dd($jobs[0]);

    // return view('home');
// });

// // Index
// Route::get('/jobs', function () {
// // Gets every record from "jobs_table" - <..latest()->simplePaginate(3)> == Latest 3 items with a Menu-Side-bar || simple define Side-bar(without simple = another Side-bar)
    // $jobs = Job::with('employer')->latest()->simplePaginate(5);
                // // . alternativ zu /
    // return view('jobs.index', [
        // 'jobs' => $jobs
    // ]);
// });

// // Create
// Route::get('/jobs/create', function () {
    // return view('jobs.create');
// });

// // Show
// Route::get('/jobs/{id}', function ($id) {
    // $job = Job::find($id);

    // return view('jobs.show', ['job' => $job]);
// });

// // Store in DB
// Route::post('/jobs', function () {
    // // Rule of input field (Error messages about input -> create.blade.php(@error))
    // request()->validate([
        // 'title' => ['required', 'min:3'],
        // 'salary' => ['required']
    // ]);

    // // Save(create) DB columns
    // Job::create([
        // 'title' => request('title'),
        // 'salary' => request('salary'),
        // 'employer_id' => 1
    // ]);

    // return redirect('/jobs');
// });

// // Edit 
// Route::get('/jobs/{id}/edit', function ($id) {
    // $job = Job::find($id);

    // return view('jobs.edit', ['job' => $job]);
// });

// // Update Jobs - ("patch" and not "post" CAUSE "patch" knows to Update data | "post" need to choice between storying new $job in 'DB' or 'Updating' it (=='/jobs/{id}/update'))
// Route::patch('/jobs/{id}', function ($id) {
    // // - Validate - Rule of input field (Error messages about input -> create.blade.php(@error))
    // request()->validate([
        // 'title' => ['required', 'min:3'],
        // 'salary' => ['required']
    // ]);
    // // - Authorize - (on hold...)

    // // - Update the job - (FindOrFail == try to find job but if u couldn't abort)
    // $job = Job::findOrFail($id);
        // /* First way to update
        //    $job->title = request('title');
        //    $job->salary = request('salary');
        //    $job->save(); 
            // */
        // // Second way to update - PREFERED WAY
    // $job->update([
        // 'title' => request('title'),
        // 'salary' => request('salary'),
    // ]);

    // // - Redirect to the job page -
    // return redirect('/jobs/' .$job->id);

        // /* Not this CAUSE never trust user (No rules or Acces)
        // $job = Job::find($id);
        // return view('jobs.show', ['job' => $job]);
    //    */
// });

// // Destroy record in DB - ("delete" and not "post" CAUSE "delete" knows to Delete data | "post" = <See COMMENT @Top>)
// Route::delete('/jobs/{id}', function ($id) {
    // // - Authorize (on hold..) -

    // // - Delete the Job -
    // Job::findOrFail($id)->delete(); // == $job = Job::FindOrFail($id);
                                    // //    $job->delete();

    // // - Redirect - 
    // return redirect('/jobs');
// });

// // Contact from job
// Route::get('/contact', function () {
    // return view('contact');
// });

// Route::get('/test', function () {
    // return view('test');
// });