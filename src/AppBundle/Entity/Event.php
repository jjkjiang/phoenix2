<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="events")
 * @ORM\Entity
 */
class Event
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(name="event_url", type="string", nullable=true)
     */
    private $eventUrl;
    
    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    private $date;
    
    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $time;
    
    /**
     * @ORM\OneToMany(targetEntity="Attendance", mappedBy="event")
     */
    private $attendees;
        
    /**
     * @ORM\Column(type="string")
     * @Assert\File(mimeTypes={ "image/gif", "image/jpeg", "image/png", "image/bmp", "image/tiff" })
     */
    private $image;
    
    public function __construct()
    {
        $this->attendees = new ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     *
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set eventUrl
     *
     * @param string $eventUrl
     *
     * @return Event
     */
    public function setEventUrl($eventUrl)
    {
        $this->eventUrl = $eventUrl;

        return $this;
    }

    /**
     * Get eventUrl
     *
     * @return string
     */
    public function getEventUrl()
    {
        return $this->eventUrl;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Event
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return Event
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Event
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add attendee
     *
     * @param \AppBundle\Entity\Attendance $attendee
     *
     * @return Event
     */
    public function addAttendee(\AppBundle\Entity\Attendance $attendee)
    {
        $this->attendees[] = $attendee;

        return $this;
    }

    /**
     * Remove attendee
     *
     * @param \AppBundle\Entity\Attendance $attendee
     */
    public function removeAttendee(\AppBundle\Entity\Attendance $attendee)
    {
        $this->attendees->removeElement($attendee);
    }

    /**
     * Get attendees
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttendees()
    {
        return $this->attendees;
    }
}
