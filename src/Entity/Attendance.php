<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="attendance")
 * @ORM\Entity
 */
class Attendance
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="events")
     * @ORM\JoinColumn(name="student_card_number", referencedColumnName="card_number")
     */
    private $attendee;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="attendees")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set attendee
     *
     * @param \App\Entity\Student $attendee
     *
     * @return Attendance
     */
    public function setAttendee(\App\Entity\Student $attendee = null)
    {
        $this->attendee = $attendee;

        return $this;
    }

    /**
     * Get attendee
     *
     * @return \App\Entity\Student
     */
    public function getAttendee()
    {
        return $this->attendee;
    }

    /**
     * Set event
     *
     * @param \App\Entity\Event $event
     *
     * @return Attendance
     */
    public function setEvent(\App\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \App\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }
}
