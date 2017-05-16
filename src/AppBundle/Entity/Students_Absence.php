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
     * @ORM\OneToOne(targetEntity="User")
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
     * @ORM\OneToOne(targetEntity="Track")
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
     * @ORM\OneToOne(targetEntity="Rule")
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
}

