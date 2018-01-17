<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use App\Entity\Student;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    /**
     * @Route("/pre_register/check", name="pre_registration_check")
     * @Method({ "POST" })
     */
    public function preRegisterCheckAction(Request $request)
    {
        // Check to see if they have registered in our database
        $email = $request->request->get('email');
        $em = $this->get('doctrine')->getManager();
        $student = $em->getRepository('App\Entity\Student')
                      ->findOneBy(array('email' => $email));

        // If the variable is empty, they were not in our system
        if (empty($student)) {
            // They're not in the system. Don't let them register.
            $this->get('session')->set('can_register', false);
            $this->get('session')->set('email', '');
            return $this->render('registration/pre_register.html.twig', [
                'error' => 'We did not find your email in our system.
                            You need to attend a general meeting first!',
            ]);
        } else {
            // We found their email. Let them register!
            $this->get('session')->set('can_register', true);
            $this->get('session')->set('email', $email);
            return $this->redirectToRoute('registration');
        }
    }

    /**
     * @Route("/pre_register", name="pre_registration")
     */
    public function preRegisterAction(Request $request)
    {
        return $this->render('registration/pre_register.html.twig');
    }

    /**
     * @Route("/register", name="registration")
     */
    public function registerAction(Request $request)
    {
        // Make sure they're set as being allowed to register before they
        // can register in the first place.
        $can_register = $this->get('session')->get('can_register', false);
        if (!$can_register) {
            return $this->redirectToRoute('pre_registration');
        }

        // Get the email we stored in the session during pre-registration
        $email = $this->get('session')->get('email', '');
        if (empty($email)) {
            return $this->redirectToRoute('pre_registration');
        }

        // Need the student object to pre-populate the form
        $em = $this->get('doctrine')->getManager();
        $student = $em->getRepository('App\Entity\Student')
                      ->findOneBy(array('email' => $email));

        // 1) Build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) Handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Extract the username from the email
            $email_array = explode('@', $user->getEmail());
            $user->setUsername($email_array[0]);

            // Set the SID from the student sign-in
            $user->setSID($student->getStudentID());

            // 3) Encode the password
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setStudent($student);
            $user->setRoles('ROLE_USER');

            // 4) Save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // Spit them back out on the homepage
            return $this->redirectToRoute('homepage');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
            'student' => $student,
        ]);
    }
}
