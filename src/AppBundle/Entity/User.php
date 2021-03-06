<?php

namespace AppBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser implements JWTUserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255,nullable = true)
     * @Assert\NotBlank()
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255,nullable = true)
     * @Assert\NotBlank()
     */
    protected $lastname;
    /**
     * @var int
     *
     * @ORM\Column(name="track_id", type="integer",nullable = true)
     */
    private $trackId;
    /**
     * @ORM\ManyToOne(targetEntity="Track", inversedBy="students")
     * @ORM\JoinColumn(name="track_id", referencedColumnName="id")
     */
    private $track;
    /**
     * @var int
     *
     * @ORM\Column(name="branch_id", type="integer",nullable = true)
     */
    private $branchId;
    /**
     * @ORM\ManyToOne(targetEntity="Branch", inversedBy="students")
     * @ORM\JoinColumn(name="branch_id", referencedColumnName="id")
     */
    private $branch;

    /**
     * @var int
     *
     * @ORM\Column(name="accAbsencePoints", type="integer",nullable = true)
     */
    private $accAbsencePoints = 0;

    public function __construct()
    {
        parent::__construct();
        $this->rules=new \Doctrine\Common\Collections\ArrayCollection();
        // your own logic
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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Creates a new instance from a given JWT payload.
     *
     * @param string $username
     * @param array $payload
     *
     * @return JWTUserInterface
     */
    public static function createFromPayload($username, array $payload)
    {
        return new self(
            $username,
            $payload['roles'], // Added by default
            $payload['email']// Custom
        );
    }

    /**
     * Set trackId
     *
     * @param integer $trackId
     *
     * @return User
     */
    public function setTrackId($trackId)
    {
        $this->trackId = $trackId;

        return $this;
    }

    /**
     * Get trackId
     *
     * @return integer
     */
    public function getTrackId()
    {
        return $this->trackId;
    }

    /**
     * Set track
     *
     * @param \AppBundle\Entity\Track $track
     *
     * @return User
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
     * Set accAbsencePoints
     *
     * @param integer $accAbsencePoints
     *
     * @return User
     */
    public function setAccAbsencePoints($accAbsencePoints)
    {
        $this->accAbsencePoints = $accAbsencePoints;
    }

    /**
     * Get accAbsencePoints
     *
     * @return integer
     */
    public function getAccAbsencePoints()
    {
        return $this->accAbsencePoints;
    }

    /**
    * Set branchId
    *
    * @param integer $branchId
    *
    * @return User
    */
   public function setBranchId($branchId)
   {
       $this->branchId = $branchId;
       return $this;
   }

    /**
     * Get branchId
     *
     * @return integer
     */
    public function getBranchId()
    {
        return $this->branchId;
    }

    /**
     * Set branch
     *
     * @param \AppBundle\Entity\Branch $branch
     *
     * @return User
     */
    public function setBranch(\AppBundle\Entity\Branch $branch = null)
    {
        $this->branch = $branch;

        return $this;
    }

    /**
     * Get branch
     *
     * @return \AppBundle\Entity\Branch
     */
    public function getBranch()
    {
        return $this->branch;
    }
}
