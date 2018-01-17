<?php

namespace App\Controller;

use App\Form\EventType;
use App\Entity\Attendance;
use App\Entity\Event;
use App\Entity\User;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/events")
 */
class EventController extends Controller
{
    /**
     * @Route("/", name="events")
     */
    public function eventIndexAction(Request $request)
    {
        $repo = $this->get('doctrine')
                     ->getManager()
                     ->getRepository('App\Entity\Event');


        $qb = $repo->createQueryBuilder('e');
        $qb
            ->where('e.date != :now')
            ->setParameter(':now', new \DateTime('yesterday'))
            ->orderBy('e.date', 'DESC');
        $events = $qb->getQuery()->getResult();

        return $this->render('events/index.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @Route("/{event_id}", name="event_view", requirements={
     *    "event_id": "\d+"})
     */
    public function eventViewAction(Request $request, $event_id)
    {
        $em = $this->get('doctrine')->getManager();
        $event = $em->getRepository('App\Entity\Event')
                   ->find($event_id);

        return $this->render('events/view.html.twig', [
            'event' => $event,
        ]);
    }
}
