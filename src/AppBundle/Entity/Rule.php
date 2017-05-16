<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rule
 *
 * @ORM\Table(name="rule")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RuleRepository")
 */
class Rule
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
     * @var string
     *
     * @ORM\Column(name="absence_status", type="string", length=255)
     */
    private $absenceStatus;

    /**
     * @var float
     *
     * @ORM\Column(name="rate", type="float")
     */
    private $rate;


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
     * Set abscenceStatus
     *
     * @param string $absenceStatus
     *
     * @return Rule
     */
    public function setAbsenceStatus($absenceStatus)
    {
        $this->absenceStatus = $absenceStatus;

        return $this;
    }

    /**
     * Get abscenceStatus
     *
     * @return string
     */
    public function getAbsenceStatus()
    {
        return $this->absenceStatus;
    }

    /**
     * Set rate
     *
     * @param float $rate
     *
     * @return Rule
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }
}
