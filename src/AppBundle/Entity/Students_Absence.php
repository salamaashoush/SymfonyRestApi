<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Students_Absence
 *
 * @ORM\Table(name="students__absence")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Students_AbsenceRepository")
 */
class Students_Absence
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="track_id", type="integer")
     */
    private $trackId;
    /**
     * @ORM\ManyToOne(targetEntity="Track")
     * @ORM\JoinColumn(name="track_id", referencedColumnName="id")
     */
    private $track;

    /**
     * @var int
     *
     * @ORM\Column(name="rule_id", type="integer")
     */
    private $ruleId;
    /**
     * @ORM\ManyToOne(targetEntity="Rule")
     * @ORM\JoinColumn(name="rule_id", referencedColumnName="id")
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Students_Absence
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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Students_Absence
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set trackId
     *
     * @param integer $trackId
     *
     * @return Students_Absence
     */
    public function setTrackId($trackId)
    {
        $this->trackId = $trackId;

        return $this;
    }

    /**
     * Get trackId
     *
     * @return int
     */
    public function getTrackId()
    {
        return $this->trackId;
    }

    /**
     * Set ruleId
     *
     * @param integer $ruleId
     *
     * @return Students_Absence
     */
    public function setRuleId($ruleId)
    {
        $this->ruleId = $ruleId;

        return $this;
    }

    /**
     * Get ruleId
     *
     * @return int
     */
    public function getRuleId()
    {
        return $this->ruleId;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Students_Absence
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
     * Set track
     *
     * @param \AppBundle\Entity\Track $track
     *
     * @return Students_Absence
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
     * Set rule
     *
     * @param \AppBundle\Entity\Rule $rule
     *
     * @return Students_Absence
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
