<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RedirectController extends Controller
{
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

    /**
     * @Route("/mentor", name="mentor")
     */
    public function mentor(Request $request)
    {
        return $this->redirect('https://goo.gl/forms/rv1TcYbiVntUPOBu2');
    }

    /**
     * @Route("/mentee", name="mentee")
     */
    public function mentee(Request $request)
    {
        return $this->redirect('https://goo.gl/forms/WOdoWhl4O8VBos282');
    }

    /**
     * @Route("/incubator", name="incubator")
     */
    public function incubator(Request $request)
    {
        return $this->redirect('https://docs.google.com/document/d/1xKG3rjqUFuj_WnjKpoqQHeQP3hquP8xYX1rIx9yucbM/edit?usp=sharing');
    }

    /**
     * @Route("/officehours", name="officehours")
     */
    public function officehours(Request $request)
    {
        return $this->redirect('https://calendar.google.com/calendar/embed?src=ucr.edu_s81hcr5v7sgqhdvnhi2re01dkg%40group.calendar.google.com&ctz=America%2FLos_Angeles');
    }

    /**
     * @Route("/resumebank", name="resumebank")
     */
    public function resumebank(Request $request)
    {
        return $this->redirect('https://docs.google.com/forms/d/e/1FAIpQLSc4BxYshPRaPNbKAW4YSrQ_tXgsTVRSAWKb7NdeemKikqiRvA/viewform');
    }

    /**
     * @Route("/interviews", name="interviews")
     */
    public function interviews(Request $request)
    {
        return $this->redirect('https://docs.google.com/forms/d/e/1FAIpQLSf4udhYICi9aVrvDxu2NAK7nLznMvcLXnxO_KR8zb0L4540CA/viewform');
    }

    /**
     * @Route("/checkin", name="checkin")
     */
    public function checkin(Request $request)
    {
        return $this->redirect('https://goo.gl/forms/TCY0AKDOvJuSNGYh1');
    }

    /**
     * @Route("/hourofcode", name="hourofcode")
     */
    public function hourofcode(Request $request)
    {
        return $this->redirect('https://acm-ucr.github.io/hour-of-code/');
    }
}
