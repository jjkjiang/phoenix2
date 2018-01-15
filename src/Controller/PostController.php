<?php

namespace App\Controller;

use App\Form\PostType;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/posts")
 */
class PostController extends Controller
{
    /**
     * @Route("/", name="posts")
     */
    public function postIndexAction(Request $request)
    {
        $repo = $this->get('doctrine')
                     ->getManager()
                     ->getRepository('App\Entity\Post');


        $qb = $repo->createQueryBuilder('p');
        $posts = $qb->getQuery()->getResult();

        return $this->render('posts/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/{post_id}", name="post_view", requirements={"post_id": "\d+"})
     */
    public function postViewAction(Request $request, $post_id)
    {
        $em = $this->get('doctrine')->getManager();
        $post = $em->getRepository('App\Entity\Post')
                   ->findOneBy(array('id' => $post_id));

        return $this->render('posts/index.html.twig', [
            'posts' => array($post),
        ]);
    }
}
