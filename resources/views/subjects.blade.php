<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subjects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $isStudent = Auth::user()->role === 'student';
                $color = $isStudent ? 'red' : 'blue';
            @endphp

            @if($isStudent)
                <div class="flex flex-col bg-white mb-4">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg p-4">
                            <label for="register">Select subject(s):</label>
                            <select name="register" id="register" class="w-full rounded mb-2" multiple>
                                @foreach ($subjects as $subject)
                                    @php
                                    $contained = $registered->contains($subject);
                                    @endphp
                                    <option value="{{ $subject->id }}" {{ $contained ? 'disabled' : '' }} class="rounded my-1 py-1 px-2">
                                        {{ $subject->name }} {{ $contained ? '(Already Registered)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="flex justify-center">
                                <button type="submit" class="px-3 py-2 border border-blue-600 rounded text-blue-600 hover:bg-blue-600 hover:text-white duration-500">
                                    Register
                                </button>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            @endif
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">{{ $isStudent ? 'De-register' : 'Class List' }}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($registered as $subject)            
                                <tr class="hover:bg-gray-100">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $subject->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="#" class="text-{{ $color }}-600 hover:text-{{ $color }}-900">
                                            {{ $isStudent ? 'De-register' : 'Class List' }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
            
                        </tbody>
                    </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>