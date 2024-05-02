<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Job;


// To configurate our App how ever you need to

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading();

        // Gate::define('edit-job', function (User $user, Job $job) {
            // return $job->employer->user->is($user);
                // // if {abort(403); } // abort == fehlermeldung 
        // });

        // Paginator::useBootstrapFive();
    }
}
