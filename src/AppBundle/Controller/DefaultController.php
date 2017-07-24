<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // Get the posts
        $repo = $this->get('doctrine')
                     ->getManager()
                     ->getRepository('AppBundle\Entity\Post');
        $qb = $repo->createQueryBuilder('p');
        $qb->orderBy('p.datePosted', 'DESC');
        $posts = $qb->getQuery()->getResult();

        // Get the events
        $repo = $this->get('doctrine')
                     ->getManager()
                     ->getRepository('AppBundle\Entity\Event');
        $qb = $repo->createQueryBuilder('e');
        $qb
            ->where('e.date > :now')
            ->setParameter(':now', new \DateTime('yesterday'))
            ->orderBy('e.date', 'ASC');
        $events = $qb->getQuery()->getResult();

        return $this->render('default/index.html.twig', [
            'posts' => $posts,
            'events' => $events,
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction(Request $request)
    {
        return $this->render('default/about.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        return $this->render('default/contact.html.twig');
    }

    /**
     * @Route("/officers", name="officers")
     */
    public function officersAction(Request $request)
    {
        return $this->render('default/officers.html.twig');
    }

    /**
     * @Route("/activities", name="activities")
     */
    public function activitiesAction(Request $request)
    {
        return $this->render('default/activities.html.twig');
    }

     /**
     * @Route("/venmo", name="venmo")
     */
    public function venmo(Request $request)
    {
        return $this->redirect('https://venmo.com/ACMUCR');
    }
     /**
     * @Route("/fb", name="fb")
     */
    public function fb(Request $request)
    {
        return $this->redirect('https://www.facebook.com/groups/acm.at.ucr/');
    }
     /**
     * @Route("/icpcbootcamp", name="icpcbootcamp")
     */
    public function icpcbootcamp(Request $request)
    {
        return $this->redirect('https://goo.gl/forms/ur5YQnChDKNAVvps2');
    }
}
