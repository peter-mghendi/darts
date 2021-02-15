// const registerButton = document.getElementById("register");
// const textBox = document.getElementById("student");
const identityContainer = document.getElementById("identity");

import { BrowserQRCodeReader } from "@zxing/library";

function setData(e, d) {
    const img = document.createElement("img");
    const id = document.createElement("p");
    const name = document.createElement("p");
    const contact = document.createElement("p");

    e.innerHTML = "";

    img.src = d.profile_photo_url;
    img.className = "rounded-full w-3/5 mx-auto mb-4";

    id.textContent = d.institutional_id;
    id.classList = "text-sm text-gray-500 uppercase";

    name.textContent = d.name;
    name.className = "text-lg";

    contact.textContent = `${d.email} | ${d.phone}`;
    contact.className = "text-sm text-gray-500 lowercase";

    e.append(img, id, name, contact);
}

function resetData(e) {
    const img = document.createElement("img");
    const text = document.createElement("p");

    e.innerHTML = "";

    img.src = scannerImage;
    img.classList = "w-3/5 opacity-50 mx-auto mb-4";

    text.textContent = "Scan your ID";
    text.classList = "text-lg text-semilight text-gray-700";

    e.append(img, text);
}

function registerAttendance(codeReader, selectedDeviceId, data) {
    axios.get("/sanctum/csrf-cookie").then((response) => {
        axios
            .post("/api/attendance", data)
            .then((res) => setData(identityContainer, res.data))
            .catch((error) => console.log(error))
            .then(
                setTimeout(() => {
                    resetData(identityContainer);
                    decodeOnce(codeReader, selectedDeviceId);
                }, 5000)
            );
    });
}

// registerButton.onclick = (obj, e) => {
//     registerAttendance({
//         student: textBox.value,
//         lesson: document.querySelector("input[name='lesson']:checked").value,
//     });
// };

function decodeOnce(codeReader, selectedDeviceId) {
    codeReader
        .decodeFromInputVideoDevice(selectedDeviceId, "scanner")
        .then((result) => {
            registerAttendance(codeReader, selectedDeviceId, {
                student: result.text,
                lesson: document.querySelector("input[name='lesson']:checked")
                    .value,
            });
            codeReader.reset();
        })
        .catch((err) => console.error(err));
}

window.addEventListener("load", function () {
    let selectedDeviceId;
    const codeReader = new BrowserQRCodeReader();
    console.log("ZXing code reader initialized");

    codeReader
        .getVideoInputDevices()
        .then((videoInputDevices) => {
            selectedDeviceId = videoInputDevices[0].deviceId;

            decodeOnce(codeReader, selectedDeviceId);
            console.log(`Decoding from camera with id ${selectedDeviceId}`);
        })
        .catch((err) => console.error(err));
});
