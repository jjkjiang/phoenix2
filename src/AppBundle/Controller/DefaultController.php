<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // Pagination
        $PAGE_SIZE = 5;
        $page = $request->query->get('page', 0);
        if ($page !== null && (!is_numeric($page) || $page < 0)) {
            throw new HttpException(400, "Page is invalid.");
        }

        // Get the posts
        $repo = $this->get('doctrine')
                     ->getManager()
                     ->getRepository('AppBundle\Entity\Post');
        $qb = $repo->createQueryBuilder('p');
        $qb->orderBy('p.datePosted', 'DESC');
        $offset = 0;
        if ($page !== null && $page > 0) {
            $offset = $page * $PAGE_SIZE;
            $qb->setFirstResult($offset);
        }
        $qb->setMaxResults($PAGE_SIZE);
        $posts = $qb->getQuery()->getResult();

        // Get total count of posts
        $query = $repo->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->getQuery();
        $total_posts = $query->getSingleScalarResult();

        $has_more_pages = ($total_posts - $offset) > $PAGE_SIZE;

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
            'has_more_pages' => $has_more_pages,
            'current_page' => $page,
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
     * @Route("/icpc", name="icpc")
     */
    public function icpcAction(Request $request)
    {
        return $this->render('default/icpc.html.twig');
    }
}
