<?php

namespace AppBundle\Controller;

use AppBundle\Form\PostType;
use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/users")
 */
class UserController extends Controller
{   
    /**
     * @Route("/{username}", name="user_view", requirements={"username": "[a-z]+[0-9]+"})
     */
    public function postViewAction(Request $request, $username)
    {
        $em = $this->get('doctrine')->getManager();
        $user = $em->getRepository('AppBundle\Entity\User')
                   ->findOneBy(array('username' => $username));
        
        return $this->render('users/profile.html.twig', [
            'user' => $user,
        ]);
    }
}
