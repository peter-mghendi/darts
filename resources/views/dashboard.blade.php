<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-greeter name="{{ Auth::user()->name }}" role="{{ Auth::user()->role }}" class="mb-8"/>
                
            @switch(Auth::user()->role)
                @case('admin')  
                    <x-admin-dashboard />

                @case('lecturer')
                    <x-lecturer-dashboard />

                @case('student')
                    <x-student-dashboard />

            @endswitch
        </div>
    </div>
</x-app-layout>