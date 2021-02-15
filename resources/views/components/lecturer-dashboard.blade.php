@if ($ongoingLessons->count() > 0)
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-4 col-span-3 md:col-span-2">
            <div class="px-4 py-5 sm:px-6">
                <div class="text-center text-xl mb-4">Record Attendance</div>
                <div class="grid grid-cols-4">
                    @foreach ($ongoingLessons as $key => $lesson)
                        <div class="col-span-4 md:col-span-2 lg:col-span-1 py-2">
                            <input type="radio" name="lesson" id="{{ $lesson->subject->id }}" value="{{ $lesson->id }}" {{ $key ?: 'checked' }} />
                            <label for="{{ $lesson->subject->id }}" class="ml-1 align-middle">
                                {{ $lesson->subject->name }} <span class="text-gray-500 border border-gray-500 rounded-full px-2">{{ $lesson->room->name }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="scanner border border-dashed h-80 flex">
                    <div class="m-auto">
                        <input type="text" name="" id="student">
                        <button id="register">Register</button>
                    </div>
                </div>
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
            const registerButton = document.getElementById("register");
            const textBox = document.getElementById("student");
            const identityContainer = document.getElementById("identity");

            function setData(e, d) {
                const img = document.createElement("img");
                const id = document.createElement("p");
                const name = document.createElement("p");
                const contact = document.createElement("p");

                e.innerHTML = "";

                img.src = d.profile_photo_url;
                img.className = "rounded-full w-3/5 mx-auto mb-4"

                id.textContent = d.institutional_id;
                id.classList = "text-sm text-gray-500 uppercase";

                name.textContent = d.name;
                name.className = "text-lg";

                contact.textContent = `${d.email} | ${d.phone}`;
                contact.className = "text-sm text-gray-500 lowercase";

                e.append(img, id, name, contact);
            }

            function resetData(e) {
                const img = document.createElement('img');
                const text = document.createElement('p');

                e.innerHTML = "";

                img.src = "{{ asset('img/scan.svg') }}";
                img.classList = "w-3/5 opacity-50 mx-auto mb-4";

                text.textContent = "Scan your ID";
                text.classList = "text-lg text-semilight text-gray-700";

                e.append(img, text);   
            }

            function registerAttendance(data) {
                axios.get("/sanctum/csrf-cookie").then(response => {
                    axios.post('/api/attendance', data)
                        .then(res => setData(identityContainer, res.data))
                        .catch(error => console.log(error))
                        .then(setTimeout(() => resetData(identityContainer), 5000))
                });
            }

            registerButton.onclick = (obj, e) => {
                registerAttendance({
                    student: textBox.value,
                    lesson: document.querySelector("input[name='lesson']:checked").value
                });
            };
        </script>
    @endpush
@endif