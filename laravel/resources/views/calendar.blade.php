<!DOCTYPE html>
<html>
<head>
    <title>FullCalendar in Laravel</title>
</head>
<body>
<div style="width: 50%;margin: auto">
    <div id='calendar'></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'ja',
            height: 'auto',
            events: '/events',
        });
        calendar.render();
    });
</script>
</body>
</html>
