<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_home")
     */
    public function adminHomeAction(Request $request)
    {
        return $this->render('admin/index.html.twig', [
            
        ]);
    }
    
    /**
     * @Route("/users", name="admin_users")
     */
    public function adminUsersAction(Request $request)
    {
        $em = $this->get('doctrine')->getManager();
        $users = $em->getRepository('AppBundle\Entity\User')
                    ->findAll();
        
        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }
    
    /**
     * @Route("/users/make_admin", name="admin_make_admin")
     */
    public function adminMakeAdminAction(Request $request)
    {

    }
}