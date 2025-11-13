import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';

let calendarEl = document.getElementById('calendar');
let calendar = new Calendar(calendarEl, {
    locale: 'es',
    timeZone: 'America/Lima',
    plugins: [dayGridPlugin, timeGridPlugin],
    initialView: 'dayGridMonth',
    editable: true,
    selectable: true,
    select: function(info) {
        console.log(info);
        
    },
    headerToolbar: {
        left: `prev,next today`,
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,listWeek'
    },
    
});
calendar.render();