<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Support\Facades\Mail;
use App\Mail\JobPosted;

class JobController extends Controller
{
    public function index()
    {
        // Gets every record from "jobs_table" - <..latest()->simplePaginate(3)> == Latest 3 items with a Menu-Side-bar || simple define Side-bar(without simple = another Side-bar)
        $jobs = Job::with('employer')->latest()->simplePaginate(5);
        return view('jobs.index', [
            'jobs' => $jobs
        ]);
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function show(Job $job)
    {
        return view('jobs.show', ['job' => $job]);
    }

    public function store()
    {
        // Rule of input field (Error messages about input -> create.blade.php(@error))
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);
        // ToDO: Die Employer_id(UnternehmenId) von dem Aktuell eingeloggten user zuteilen -- DONE == Testing
        $employerId = auth()->user()->employer->id;

        // Save(create) DB columns
        $job = Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => $employerId
            // 'employer_id' => $employerId
            // 'employer_id' => auth()->user()->employer->id
            // 'employer_id' => 1
        ]);
                                    // queue or send == if(queue) { Cmd > "./vendor/bin/sail artisan queue:work" <||> "php artisan queue:work"}
        Mail::to($job->employer->user)->queue(
            new JobPosted($job)
        );

    return redirect('/jobs');
    }

    public function edit(Job $job)
    {
        // if (Auth::guest()) {
            // return redirect('/login');
        // }
        //    if (Auth::user()->cannot('edit-job', $job)) {
                // dd('failure');
            // }

                        // References with the same function name
        // Gate::authorize('edit-job', $job); // doesnt need anymore, routes a single defined

        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Job $job)
    {
        Gate::authorize('edit', $job);

        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);
        // $job = Job::findOrFail($job);
        $job->update([
            'title' => request('title'),
            'salary' => request('salary'),
        ]);

    // - Redirect to the job page -
    return redirect('/jobs/' . $job->id);
    }

    public function destroy(Job $job)
    {
        Gate::authorize('edit', $job);
        // - Delete the Job -
        $job->delete();
        // - Redirect to the job page - <<((Job::findOrFail($job)->delete();))>>
        return redirect('/jobs');
    }
}
