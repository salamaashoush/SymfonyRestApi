<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Rule
 *
 * @ORM\Table(name="rule")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RuleRepository")
 */
class Rule
{

    /**
     * Many Groups have Many Users.
     *  @ORM\ManyToMany(targetEntity="User", mappedBy="rules")
     */
    
    private $users;
    /**
     * Many Rules applied To Many Tracks.
     *  @ORM\ManyToMany(targetEntity="Track", mappedBy="rules")
     */
    
    private $tracks;

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var array
     *
     * @ORM\Column(type="string", columnDefinition="ENUM('sub','add')")
     */
    private $type='sub';

    /**
     * @var array
     *
     * @ORM\Column(type="string", columnDefinition="ENUM('late', 'absence')" )
     */
    private $state='late';

    /**
     * @var int
     *
     * @ORM\Column(name="period", type="smallint", nullable=true)
     */
    private $period;

    /**
     * @var int
     *
     * @ORM\Column(name="penalty", type="smallint")
     */
    private $penalty;

    public function __construct() {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tracks = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set name
     *
     * @param string $name
     *
     * @return Rule
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
     * Set type
     *
     * @param array $type
     *
     * @return Rule
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return array
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set state
     *
     * @param array $state
     *
     * @return Rule
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return array
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set period
     *
     * @param integer $period
     *
     * @return Rule
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return int
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set penalty
     *
     * @param integer $penalty
     *
     * @return Rule
     */
    public function setPenalty($penalty)
    {
        $this->penalty = $penalty;

        return $this;
    }

    /**
     * Get penalty
     *
     * @return int
     */
    public function getPenalty()
    {
        return $this->penalty;
    }

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('rule_type', CollectionType::class, array(
            'entry_type'   => ChoiceType::class,
            'entry_options'  => array(
            'choices'  => array(
                'Add' => 'add',
                'Sub'     => 'sub'
                ),
            ),
        ));
    }
}

