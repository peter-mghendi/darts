import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";

import Swal from "sweetalert2";

const calendarEl = document.getElementById("calendar");

function getClassStatus(classInfo) {
    let status = classInfo.extendedProps.status;
    if (status && status.trim()) {
        return classInfo.extendedProps.status;
    }

    console.log(new Date());
    console.log(classInfo.start);
    console.log(classInfo.end);
    console.log(now < new Date(classInfo.start));
    console.log(now > new Date(classInfo.end));

    const now = new Date();
    if (now < new Date(classInfo.start)) return "Scheduled";
    if (now > new Date(classInfo.end)) return "Completed";

    return "Ongoing";
}

let calendar = new Calendar(calendarEl, {
    plugins: [dayGridPlugin, timeGridPlugin, listPlugin],
    initialView: "dayGridMonth",
    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,listWeek,timeGridDay",
    },

    events: events,

    weekNumbers: true,
    navLinks: true,

    businessHours: {
        daysOfWeek: [1, 2, 3, 4, 5],
        startTime: "07:00",
        endTime: "16:00",
    },

    dayMaxEventRows: true,
    eventClick: function (info) {
        const event = info.event;
        const action = event.extendedProps.role === "student" ? "Attended" : "Taught";

        let text = `Subject: ${event.title} - ${event.extendedProps.class}<br>` 
            + `Venue: ${event.extendedProps.room}<br>` 
            + `Class Status: ${getClassStatus(event)}<br>` 
            + `${action}: ${event.extendedProps.attended}<br>` 
            + `Lecturer's Comments: <br>${event.extendedProps.comment}<br>`;

        Swal.fire(`Lesson #${event.id} Details`, text, "info");
    },
});

calendar.render();
