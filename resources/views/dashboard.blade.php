<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $user = Auth::user();
                $role = $user->role;
            @endphp
            <x-greeter name="{{ $user->name }}" role="{{ $role }}" class="mb-8"/>

            @if (in_array($role, ['student', 'lecturer']))
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-4">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Ongoing Classes</h3>
                        <hr>
                        @forelse ($lessons as $lesson)
                            <div class="d-flex p-2 hover:bg-gray-100">
                                <h5 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ $lesson->subject->id }}: {{ $lesson->subject->name }}
                                </h5>
                                <p class="mt-1 max-w-2xl text-gray-700">
                                    {{ (new DateTime($lesson->start_time))->format('H:i') }} - {{ (new DateTime($lesson->end_time))->format('H:i') }}
                                </p>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    {{ $lesson->room->name }}
                                </p>
                            </div>
                        @empty
                            <h5 class="text-lg leading-6 font-medium text-gray-900">
                                No ongoing classes   
                            </h5>
                        @endforelse
                    </div>
                </div>
            @endif
                
            @switch($role)
                @case('admin')  
                    <x-admin-dashboard />
                    @break

                @case('lecturer')
                    <x-lecturer-dashboard />
                    @break

                @case('student')
                    <x-student-dashboard />
                    @break

            @endswitch
        </div>
    </div>
</x-app-layout>