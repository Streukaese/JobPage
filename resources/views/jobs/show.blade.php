<x-layout>
    <x-slot:heading>
        Job
    </x-slot:heading>
    <h2 class="font-bold text-lg">{{ $job->title }}</h2>

    <p>            
        This job pay {{ $job['salary' ]}} per year.
    </p>
            {{-- 'edit' Ruft den Gateway im JobController auf und überprüft die berechtigung --}}
    @can('edit', $job)
        <p class="mt-6">
            <x-button href="/jobs/{{ $job->id }}/edit">Edit Job</x-button>
        </p>
    @endcan
</x-layout>