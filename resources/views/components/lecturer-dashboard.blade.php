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
                                {{ $lesson->subject->name }} : {{ $lesson->room->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="scanner">
                    <input type="text" name="" id="student">
                    <button id="register">Register</button>
                </div>
            </div>
        </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-4 col-span-3 md:col-span-1">
            <div class="px-4 py-5 sm:px-6 text-center">
                <p class="text-xl mb-4">Identity&trade;</p>
                <div id="identity"></div>
            </div>
        </div>
    </div> 

    @push('scripts')
        <script>
            const registerButton = document.getElementById("register");
            const textBox = document.getElementById("student");
            const identityContainer = document.getElementById("identity");

            function setData(d) {
                const img = document.createElement("img");
                const id = document.createElement("p");
                const name = document.createElement("p");
                const contact = document.createElement("p");

                identityContainer.innerHTML = "";

                img.src = d.profile_photo_url;
                img.className = "rounded-full w-3/5 mx-auto mb-3"

                id.textContent = d.institutional_id;
                id.classList = "text-sm text-gray-500 uppercase";

                name.textContent = d.name;
                name.className = "text-lg";

                contact.textContent = `${d.email} | ${d.phone}`;
                contact.className = "text-sm text-gray-500 lowercase";

                identityContainer.appendChild(img);
                identityContainer.appendChild(id);
                identityContainer.appendChild(name);
                identityContainer.appendChild(contact);
            }

            registerButton.onclick = (obj, e) => {
                const data = {
                    student: textBox.value,
                    lesson: document.querySelector("input[name='lesson']:checked").value
                };

                axios.get("/sanctum/csrf-cookie").then(response => {
                    axios.post('/api/attendance', data, { withCookie: true })
                        .then(res => setData(res.data))
                        .catch(error => console.log(error))
                        .then(setTimeout(() => identityContainer.innerHTML = "", 5000))
                })
            };
        </script>
    @endpush
@endif