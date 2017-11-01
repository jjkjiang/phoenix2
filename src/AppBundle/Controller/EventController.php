<?php

namespace AppBundle\Controller;

use AppBundle\Form\EventType;
use AppBundle\Entity\Attendance;
use AppBundle\Entity\Event;
use AppBundle\Entity\User;
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
                     ->getRepository('AppBundle\Entity\Event');


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
        $event = $em->getRepository('AppBundle\Entity\Event')
                   ->find($event_id);

        return $this->render('events/view.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/new", name="event_new")
     */
    public function eventNewAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // $file stores the uploaded image file
            $file = $event->getImage();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $directory = $this->getParameter('event_image_directory');
            $file->move(
                $directory,
                $fileName
            );

            // Create the full name from the upload directory
            // and the newly made filename
            $full_name = $directory . $fileName;

            // Update the 'image' property to store the image file name
            // instead of its contents
            $event->setImage($full_name);

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            $event_id = $event->getId();

            return $this->redirectToRoute('event_view', [
                'event_id' => $event_id,
            ]);
        }

        return $this->render('events/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/attendance", name="events_attendance")
     */
    public function eventAttendanceAction(Request $request)
    {
        $repo = $this->get('doctrine')
                     ->getManager()
                     ->getRepository('AppBundle\Entity\Event');

        $qb = $repo->createQueryBuilder('e');
        $qb->orderBy('e.date', 'ASC');
        $events = $qb->getQuery()->getResult();

        return $this->render('attendance/index.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @Route("/{event_id}/attendance", name="event_attendance", requirements={
     *    "event_id": "\d+"})
     * @Method({ "GET" })
     */
    public function eventAttendanceViewAction(Request $request, $event_id)
    {
        $em = $this->get('doctrine')->getManager();
        $event = $em->getRepository('AppBundle\Entity\Event')
            ->find($event_id);

        $query = $em->createQuery(
            'SELECT s.name, s.email
             FROM AppBundle\Entity\Attendance a
             JOIN a.event e
             JOIN a.attendee s
             WHERE e.id = ?1 '
        );
        $query->setParameter(1, $event_id);
        $attendees = $query->getResult();

        return $this->render('attendance/event.html.twig', [
            'event' => $event,
            'attendees' => $attendees,
        ]);
    }

    /**
     * @Route("/{event_id}/attendance", name="event_take_attendance", requirements={"event_id": "\d+"})
     * @Method({ "POST" })
     */
    public function eventTakeAttendance(Request $request, $event_id)
    {
        // Get the event
        $em = $this->get('doctrine')->getManager();
        $event = $em->getRepository('AppBundle\Entity\Event')
            ->find($event_id);

        // Now need to find all checked-in students
        $student_repo = $this->get('doctrine')
            ->getManager()
            ->getRepository('AppBundle\Entity\Student');

        $qb = $student_repo->createQueryBuilder('s');
        $qb->where('s.checkedIn = true');
        $students = $qb->getQuery()->getResult();

        // Iterate over the students and mark them as attendees
        foreach ($students as $student) {
            // Create the new attendance object
            $attendance = new Attendance();
            $attendance->setAttendee($student);
            $attendance->setEvent($event);
            $event->addAttendee($attendance);

            // Mark the student as not checked in
            $student->setCheckedIn(false);

            // Update ALL the DB entries!!!
            $em->persist($attendance);
            $em->persist($student);
            $em->persist($event);
        }
        $em->flush();

        return $this->redirectToRoute('event_attendance', [
            'event_id' => $event_id,
        ]);
    }

    /**
     * Displays a form to edit an existing Event entity.
     *
     * @Route("/{event_id}/edit", name="event_edit")
     * @Method({"GET", "POST"})
     */
    public function eventEditAction(Request $request, $event_id)
    {
        $em = $this->get('doctrine')->getManager();
        $event = $em->getRepository('AppBundle\Entity\Event')
                   ->find($event_id);

        $prev_image_path = $event->getImage();
        $event->setImage(null);

        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('AppBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // $file stores the uploaded image file
            $file = $event->getImage();

            if (!empty($file)) {
                // Generate a unique name for the file before saving it
                $fileName = md5(uniqid()).'.'.$file->guessExtension();

                // Move the file to the directory where brochures are stored
                $directory = $this->getParameter('event_image_directory');
                $file->move(
                    $directory,
                    $fileName
                );

                // Create the full name from the upload directory
                // and the newly made filename
                $full_name = $directory . $fileName;

                // Update the 'image' property to store the image file name
                // instead of its contents
                $event->setImage($full_name);
            } else {
                // They didn't upload a new image, so use the previous one
                $event->setImage($prev_image_path);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_view', [
                'event_id' => $event->getId(),
            ]);
        }

        return $this->render('events/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Event entity.
     *
     * @Route("/{event_id}", name="event_delete", requirements={
     *    "event_id": "\d+"})
     * @Method("DELETE")
     */
    public function eventDeleteAction(Request $request, $event_id)
    {
        $em = $this->get('doctrine')->getManager();
        $event = $em->getRepository('AppBundle\Entity\Event')
                   ->findOneBy(array('id' => $event_id));

        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('events');
    }

    /**
     * Creates a form to delete a Event entity.
     *
     * @param Event $event The Event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', [
               'event_id' => $event->getId(),
            ]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
