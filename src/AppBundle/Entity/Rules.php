<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rules
 *
 * @ORM\Table(name="rules")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RulesRepository")
 */
class Rules
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
     * @ORM\Column(name="Abscence_Status", type="string", length=255)
     */
    private $abscenceStatus;

    /**
     * @var float
     *
     * @ORM\Column(name="Rate", type="float")
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
     * @param string $abscenceStatus
     *
     * @return Rules
     */
    public function setAbscenceStatus($abscenceStatus)
    {
        $this->abscenceStatus = $abscenceStatus;

        return $this;
    }

    /**
     * Get abscenceStatus
     *
     * @return string
     */
    public function getAbscenceStatus()
    {
        return $this->abscenceStatus;
    }

    /**
     * Set rate
     *
     * @param float $rate
     *
     * @return Rules
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

