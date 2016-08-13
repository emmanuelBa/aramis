<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Option
 *
 * @ORM\Table(name="options", indexes={@ORM\Index(name="option_car_FK", columns={"car_id"})})
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\Option")
 * 
 * @ExclusionPolicy("all")
 */
class Option extends BaseEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     * 
     * @Assert\NotBlank(message="Equipment name is required")
     * @Assert\Length(
     *  min=1, 
     *  max=50, 
     *  minMessage="Option name has min length 1", 
     *  maxMessage="Option name has max length 50"
     * )
     * 
     * @Expose
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \ApiBundle\Entity\Car
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Car", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="car_id", referencedColumnName="id")
     * })
     */
    private $car;



    /**
     * Set name
     *
     * @param string $name
     *
     * @return Option
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Option
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Option
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
     * Set car
     *
     * @param \ApiBundle\Entity\Car $car
     *
     * @return Option
     */
    public function setCar(\ApiBundle\Entity\Car $car = null)
    {
        $this->car = $car;

        return $this;
    }

    /**
     * Get car
     *
     * @return \ApiBundle\Entity\Car
     */
    public function getCar()
    {
        return $this->car;
    }


    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Option
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
