<x-layout>
<x-slot:heading>
    Jobs Listings
</x-slot:heading>

<h1>Hello from the Job Page.</h1>
Test 2
    <div class="space-y-4">
        @foreach ($jobs as $job) 
            <a href="/jobs/{{ $job['id'] }}" class="block px-4 py-6 border border-gray-200 rounded-lg">
                @if ($job->employer) <!-- Überprüfe, ob ein Arbeitgeber vorhanden ist -->
                <div class="font-bold text-blue-400 text-sm">{{ $job->employer->name }}</div>
                @endif
                {{-- <div class="font-bold text-blue-400 text-sm">{{ $job->employer->name }}</div> --}}

                <div>
                    <strong>{{ $job['title'] }}:</strong> Pays {{ $job['salary'] }} per year.
                </div>
            </a>    
        @endforeach
        <div>
            {{ $jobs->links() }}
        </div>
    </div>
</x-layout>