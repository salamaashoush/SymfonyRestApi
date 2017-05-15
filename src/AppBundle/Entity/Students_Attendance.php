<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Students_Attendance
 *
 * @ORM\Table(name="students__attendance")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Students_AttendanceRepository")
 */
class Students_Attendance
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="arrival_time", type="datetime", nullable=true)
     */
    private $arrivalTime;
    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer",nullable = true)
     */
    private $userId;
    /**
    * One user has One attendace record per day.
    * @OneToOne(targetEntity="User")
    * @JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;
    /**
     * @var int
     *
     * @ORM\Column(name="track_id", type="integer",nullable = true)
     */
    private $trackId;
    /**
    * One user has One attendace record per day in a certain track.
    * @OneToOne(targetEntity="Track")
    * @JoinColumn(name="track_id", referencedColumnName="id")
    */
    private $track;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Students_Attendance
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set arrivalTime
     *
     * @param \DateTime $arrivalTime
     *
     * @return Students_Attendance
     */
    public function setArrivalTime($arrivalTime)
    {
        $this->arrivalTime = $arrivalTime;

        return $this;
    }

    /**
     * Get arrivalTime
     *
     * @return \DateTime
     */
    public function getArrivalTime()
    {
        return $this->arrivalTime;
    }

    /**
     * Set track
     *
     * @param \AppBundle\Entity\Track $track
     *
     * @return Students_Attendance
     */
    public function setTrack(\AppBundle\Entity\Track $track = null)
    {
        $this->track = $track;

        return $this;
    }

    /**
     * Get track
     *
     * @return \AppBundle\Entity\Track
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Students_Attendance
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
