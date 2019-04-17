$(function () {

    $('#prev').on('click', function() {
       $('#calendar').fullCalendar('prev'); // call method
    });

    $('#next').on('click', function() {
       $('#calendar').fullCalendar('next'); // call method
    });
    $("#calendar-holder").fullCalendar({
        locale: "fr",
        header: {
            left: "prev, next, today",
            center: "title",
            right: "month, agendaWeek, agendaDay"
        },
        lazyFetching: true,
        navLinks: true,
        eventSources: [
            {
                url: "/fc-load-events",
                type: "POST",
                data:  {
                    filters: {}
                },
                error: function () {
                    alert("There was an error while fetching FullCalendar !");
                }
            }
        ]
    });
});




