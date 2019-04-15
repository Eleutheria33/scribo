<?php

namespace App\EventListener;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;
use App\Entity\Calendrier;
use App\Repository\CalendrierRepository;


class FullCalendarListener
{
    private $calendrierRepository;
    private $router;

    public function __construct(
        CalendrierRepository $calendrierRepository,
        UrlGeneratorInterface $router
    ) {
        $this->calendrierRepository = $calendrierRepository;
        $this->router = $router;
    }


public function loadEvents(CalendarEvent $calendar): void
    {
        $startDate = $calendar->getStart();
        $endDate = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change b.beginAt by your start date in your custom entity
        $calendriers = $this->calendrierRepository
            ->createQueryBuilder('b')
            ->andWhere('b.beginAt BETWEEN :startDate and :endDate')
            ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($calendriers as $calendrier) {

            // this create the events with your own entity (here booking entity) to populate calendar
            $bookingEvent = new Event(
                $calendrier->getTitle(),
                $calendrier->getBeginAt(),
                $calendrier->getEndAt() // If the end date is null or not defined, it creates a all day event
            );

            /*
             * Optional calendar event settings
             *
             * For more information see : Toiba\FullCalendarBundle\Entity\Event
             * and : https://fullcalendar.io/docs/event-object
             */
            // $bookingEvent->setUrl('http://www.google.com');
            // $bookingEvent->setBackgroundColor($booking->getColor());
            // $bookingEvent->setCustomField('borderColor', $booking->getColor());

            $bookingEvent->setUrl(
                $this->router->generate('calendrier_show', [
                    'id' => $calendrier->getId(),
                ])
            );

            // finally, add the booking to the CalendarEvent for displaying on the calendar
            $calendar->addEvent($bookingEvent);
        }
    }

}
