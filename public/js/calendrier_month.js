$(function () {

    $('#calendar').fullCalendar({
        header: {
            left:   '',
            center: 'title',
            right:  ''
        },
        themeSystem: 'bootstrap4',
        events: [
        // my event data
          ],
        eventColor: '#378006',
        lazyFetching: true,
        navLinks: true

    });

// fonction de récupération de la date (mois, etc.) sur le calendrier
    $('a.fc-day-number').click(function(event) {
       event.preventDefault();
       alert('coucou & re');
       console.log(event.target);
       var month = $(this).data('goto').date
       var res = month.split("-");
       console.log(res[1]);

       return false;  // indispensable pour faire fonctionner event.preventDefault
    });
});
