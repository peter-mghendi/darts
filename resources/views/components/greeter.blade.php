@props(['name', 'role'])

<div class="bg-white shadow overflow-hidden sm:rounded-lg mb-4">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Hello, {{ $name }}!
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
            @switch($role)
                @case('admin')   
                    Welcome to your administrative dashboard.
                @case('lecturer')
                    Welcome to your lecturer dashboard.
                @case('student')
                    Welcome to your student dashboard.
            @endswitch
        </p>
    </div>
</div>