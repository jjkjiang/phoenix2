<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="students")
 * @ORM\Entity
 */
class Student
{   
    /**
     * @ORM\Column(type="string", length=256)
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    private $email;
    
    /**
     * @ORM\Column(name="checked_in", type="boolean")
     */
    private $checkedIn = false;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $points = 0;
    
    /**
     * @ORM\Column(name="card_number", type="string", length=256)
     * @ORM\Id
     */
    private $cardNumber;
    
    /**
     * @ORM\Column(name="paid", type="boolean")
     */
    private $paid = false;
    
    /**
     * @ORM\Column(name="tshirt_size", type="string", length=8, nullable=true)
     */
    private $shirtSize;
    
    /**
     * @ORM\Column(name="s_id", type="string", length=256)
     */
    private $studentID;
    
    /**
     * @ORM\OneToMany(targetEntity="Attendance", mappedBy="attendee")
     */
    private $events;
    
    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Student
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Student
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set checkedIn
     *
     * @param boolean $checkedIn
     *
     * @return Student
     */
    public function setCheckedIn($checkedIn)
    {
        $this->checkedIn = $checkedIn;

        return $this;
    }

    /**
     * Get checkedIn
     *
     * @return boolean
     */
    public function getCheckedIn()
    {
        return $this->checkedIn;
    }

    /**
     * Set points
     *
     * @param integer $points
     *
     * @return Student
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set cardNumber
     *
     * @param string $cardNumber
     *
     * @return Student
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * Get cardNumber
     *
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * Set paid
     *
     * @param boolean $paid
     *
     * @return Student
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return boolean
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Set shirtSize
     *
     * @param string $shirtSize
     *
     * @return Student
     */
    public function setShirtSize($shirtSize)
    {
        $this->shirtSize = $shirtSize;

        return $this;
    }

    /**
     * Get shirtSize
     *
     * @return string
     */
    public function getShirtSize()
    {
        return $this->shirtSize;
    }

    /**
     * Set studentID
     *
     * @param string $studentID
     *
     * @return Student
     */
    public function setStudentID($studentID)
    {
        $this->studentID = $studentID;

        return $this;
    }

    /**
     * Get studentID
     *
     * @return string
     */
    public function getStudentID()
    {
        return $this->studentID;
    }

    /**
     * Add event
     *
     * @param \AppBundle\Entity\Attendance $event
     *
     * @return Student
     */
    public function addEvent(\AppBundle\Entity\Attendance $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \AppBundle\Entity\Attendance $event
     */
    public function removeEvent(\AppBundle\Entity\Attendance $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }
}
