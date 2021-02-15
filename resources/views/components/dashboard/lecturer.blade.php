@if ($ongoingLessons->count() > 0)
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-4 col-span-3 md:col-span-2">
            <div class="px-4 py-5 sm:px-6">
                <div class="text-center text-xl mb-4">Record Attendance</div>
                <div class="grid grid-cols-4 mb-3">
                    @foreach ($ongoingLessons as $key => $lesson)
                        <div class="col-span-4 md:col-span-2 lg:col-span-1 py-2">
                            <input type="radio" name="lesson" id="{{ $lesson->subject->id }}" value="{{ $lesson->id }}" {{ $key ?: 'checked' }} />
                            <label for="{{ $lesson->subject->id }}" class="ml-1 align-middle">
                                {{ $lesson->subject->name }} <span class="text-gray-500 border border-gray-500 rounded-full px-2">{{ $lesson->room->name }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
                <video src="" id="scanner" class="border border-dashed rounded-lg h-80 w-full bg-indigo-100"></video>
                {{-- <div class="scanner border border-dashed h-80 flex">
                    <div class="m-auto">
                        <input type="text" name="" id="student">
                        <button id="register">Register</button>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-4 col-span-3 md:col-span-1">
            <div class="px-4 py-5 sm:px-6 text-center flex flex-col h-full">
                <p class="text-xl mb-4">Identity&trade;</p>
                <div id="identity" class="my-auto">
                    <img src="{{ asset('img/scan.svg') }}" alt="QR code scanner" class="w-3/5 opacity-50 mx-auto mb-4">
                    <p class="text-lg text-gray-500">Scan a QR Code</p>
                </div>
            </div>
        </div>
    </div> 

    @push('scripts')
        <script>
            const scannerImage = @json(asset('img/scan.svg'));
        </script>
        <script src="{{ mix('js/dashboard/lecturer.js') }}" defer></script>
    @endpush
@endif