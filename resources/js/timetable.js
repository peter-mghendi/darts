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

        let text = `Session ID: ${event.id}<br>`;
        text += `Class: ${event.title}: ${event.extendedProps.class}\n`;
        text += `Venue: ${event.extendedProps.hall}\n`;
        text += `Class Status: ${getClassStatus(event)}\n`;
        text += `Attended: ${event.extendedProps.attended}\n`;
        text += `Lecturer's Comments: \n${event.extendedProps.comment}\n`;

        Swal.fire("Session Details", text);
    },
});

calendar.render();
