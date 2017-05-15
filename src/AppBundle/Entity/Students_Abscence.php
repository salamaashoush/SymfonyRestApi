<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Students_Abscence
 *
 * @ORM\Table(name="students__abscence")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Students_AbscenceRepository")
 */
class Students_Abscence
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
     * @var \DateTime
     *
     * @ORM\Column(name="abscence_date", type="datetime")
     */
    private $abscenceDate;
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
     * @var int
     *
     * @ORM\Column(name="rule_id", type="integer",nullable = true)
     */
    private $ruleId;
    /**
    * One user has One abscence status from thr rules table.
    * @OneToOne(targetEntity="Rule")
    * @JoinColumn(name="rule_id", referencedColumnName="id")
    */
    private $rule;

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
     * Set abscenceDate
     *
     * @param \DateTime $abscenceDate
     *
     * @return Students_Abscence
     */
    public function setAbscenceDate($abscenceDate)
    {
        $this->abscenceDate = $abscenceDate;

        return $this;
    }

    /**
     * Get abscenceDate
     *
     * @return \DateTime
     */
    public function getAbscenceDate()
    {
        return $this->abscenceDate;
    }

    /**
     * Set track
     *
     * @param \AppBundle\Entity\Track $track
     *
     * @return Students_Abscence
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
     * @return Students_Abscence
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

    /**
     * Set rule
     *
     * @param \AppBundle\Entity\Rule $rule
     *
     * @return Students_Abscence
     */
    public function setRule(\AppBundle\Entity\Rule $rule = null)
    {
        $this->rule = $rule;

        return $this;
    }

    /**
     * Get rule
     *
     * @return \AppBundle\Entity\Rule
     */
    public function getRule()
    {
        return $this->rule;
    }
}
