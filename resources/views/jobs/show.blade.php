<x-layout>
    <x-slot:heading>
        Job
    </x-slot:heading>
{{-- {{ $job->id }} == {{ $job['salary' ]}} || its the same, typical is the actually prefered syntax --}}
    <h2 class="font-bold text-lg">{{ $job->title }}</h2>

    <p>            {{-- == {{ $job->id }} --}}
        This job pay {{ $job['salary' ]}} per year.
    </p>
            
    @can('edit', $job)
    <p class="mt-6">        {{-- == {{ $job['salary' ]}} --}}
        <x-button href="/jobs/{{ $job->id }}/edit">Edit Job</x-button>
    </p>
    @endcan
</x-layout>