import { BrowserQRCodeReader } from "@zxing/browser";
import axios from "axios";

const identityContainer = document.getElementById("identity");
/** Duration user details flash on screen. */
const DELAY = 5 * 1000; // 5 seconds

/** 
 * Duration past which the system will not accept registration.
 * Set to <= 0 to disable this feature.
 */
const DEADLINE = 15 * 60 * 1000; // 15 minutes

/**
 * @param {HTMLElement} e
 * @param {Object} d
 */
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

/**
 * @param {HTMLElement} e
 */
function resetData(e) {
    const img = document.createElement("img");
    const text = document.createElement("p");

    img.src = scannerImage;
    img.classList = "w-3/5 opacity-50 mx-auto mb-4";

    text.textContent = "Scan your ID";
    text.classList = "text-lg text-semilight text-gray-700";

    e.innerHTML = "";
    e.append(img, text);
}

/**
 * @param {{student: string, lesson: string}} data
 * @todo Appropriate UI feedback on error
 */
async function registerAttendance(data) {
    return await axios
        .post("/api/attendance", data)
        .then((res) => setData(identityContainer, res.data))
        .catch((error) => console.log(error));
}

/**
 * @param {BrowserQRCodeReader} codeReader
 * @param {string} selectedDeviceId
 * @param {string | HTMLVideoElement} previewElement
 */
async function decodeOnce(codeReader, selectedDeviceId, previewElement) {
    const mainControls = await codeReader.decodeFromVideoDevice(
        selectedDeviceId,
        previewElement,
        async (result, error, controls) => {
            if (!error) {
                controls.stop();
                
                await registerAttendance({
                    student: result.text,
                    lesson: document.querySelector(
                        "input[name='lesson']:checked"
                    ).value,
                });

                setTimeout(async () => {
                    resetData(identityContainer);
                    await decodeOnce(
                        codeReader,
                        selectedDeviceId,
                        previewElement
                    );
                }, DELAY);

                return;
            }

            // console.error(error); // This is congesting the console
        }
    );

    // Lock latecomers out
    if (DEADLINE > 0) setTimeout(() => mainControls.stop(), DEADLINE);
}

window.addEventListener("load", async function () {
    let selectedDeviceId;
    const codeReader = new BrowserQRCodeReader();

    const videoInputDevices = await BrowserQRCodeReader.listVideoInputDevices();
    selectedDeviceId = videoInputDevices[0].deviceId;
    await decodeOnce(codeReader, selectedDeviceId, "scanner");
});
