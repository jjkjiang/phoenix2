<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Student;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/swiper")
 */
class SwiperController extends Controller
{
    /**
     * @Route("/", name="swiper_home")
     */
    public function swiperHomeAction(Request $request)
    {
        return $this->render('swiper/index.html.twig', [

        ]);
    }

    /**
     * @Route("/submit", name="swiper_submit")
     * @Method({"POST"})
     */
    public function swiperSubmitAction(Request $request)
    {
        $name = $request->request->get('s_name');
        $sid = $request->request->get('s_id');
        $card_number = $request->request->get('card_number');

        $em = $this->get('doctrine')->getManager();
        $student = $em->getRepository('AppBundle\Entity\Student')
            ->find($card_number);

        if (empty($student)) {
            return new Response('', 420);
        }

        if ($student->getCheckedIn()) {
            return new Response('', 421);
        }

        $student->setCheckedIn(true);
        $em->flush();
        return new Response('', 200);
    }

    /**
     * @Route("/enroll", name="swiper_enroll")
     * @Method({"POST"})
     */
    public function swiperEnrollAction(Request $request)
    {
        $name = $request->request->get('s_name');
        $sid = $request->request->get('s_id');
        $email = $request->request->get('email');
        $card_number = $request->request->get('card_number');

        $student = new Student();
        $student->setName($name);
        $student->setStudentID($sid);
        $student->setEmail($email);
        $student->setCardNumber($card_number);
        $student->setCheckedIn(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($student);
        $em->flush();

        return new Response('', 200);
    }
}
