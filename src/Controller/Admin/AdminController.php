<?php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $users = $em->getRepository('App\Entity\User')
                    ->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/users/make_admin", name="admin_make_admin")
     * @Method("POST")
     */
    public function adminMakeAdminAction(Request $request)
    {
        $em = $this->get('doctrine')->getManager();
        $user_id = $request->request->get('user_id');
        $user = $em->getRepository('App\Entity\User')->find($user_id);

        if (!$user) {
            return new JsonResponse([
                'msg' => 'Could not locate user with the given id',
            ], 400);
        }

        $user_name = $user->getName();
        if ($user->getRole() === 'ROLE_ADMIN') {
            return new JsonResponse([
                'msg' => "$user_name is already an admin.",
            ], 420);
        }

        $user->setRole('ROLE_ADMIN');
        $em->persist($user);
        $em->flush();

        return new JsonResponse([
            'msg' => "Added $user_name as admin.",
        ]);
    }

    /**
     * @Route("/users/revoke_admin", name="admin_revoke_admin")
     * @Method("POST")
     */
    public function adminRevokeAdminAction(Request $request)
    {
        $em = $this->get('doctrine')->getManager();
        $user_id = $request->request->get('user_id');
        $user = $em->getRepository('App\Entity\User')->find($user_id);

        if (!$user) {
            return new JsonResponse([
                'msg' => 'Could not locate user with the given id',
            ], 400);
        }

        $user_name = $user->getName();
        if ($user->getRole() === 'ROLE_USER') {
            return new JsonResponse([
                'msg' => "$user_name is already an admin.",
            ], 420);
        }

        $user->setRole('ROLE_USER');
        $em->persist($user);
        $em->flush();

        return new JsonResponse([
            'msg' => "Revoked admin rights from $user_name.",
        ]);
    }
}
