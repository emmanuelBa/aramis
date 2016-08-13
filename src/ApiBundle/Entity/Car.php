<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Car
 *
 * @ORM\Table(name="car")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\Car")
 * 
 * @ExclusionPolicy("all")
 */
class Car extends BaseEntity
{
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->option = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipment = new \Doctrine\Common\Collections\ArrayCollection();
    }

    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     * @Assert\NotBlank(
     *  groups={"update"}, 
     *  message="Please indicate car id"
     * )
     * 
     * @Expose
     */
    private $id;
   
    /**
     * @var string
     *
     * @ORM\Column(name="maker", type="string", length=50, nullable=false)
     * 
     * @Assert\NotBlank(message="Maker is required")
     * @Assert\Length(
     *  min=1, 
     *  max=50, 
     *  minMessage="Maker has min length 1", 
     *  maxMessage="Maker has max length 50"
     * )
     * 
     * @Expose
     */
    private $maker;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=50, nullable=false)
     * 
     * @Assert\NotBlank(message="Model is required")
     * @Assert\Length(
     *  min=1, 
     *  max=50, 
     *  minMessage="Model has min length 1", 
     *  maxMessage="Model has max length 50"
     * )
     * 
     * @Expose
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     * 
     * @Assert\NotBlank(message="Price is required")
     * @Assert\GreaterThan(
     *     value = 0,
     *     message = "Price must be greater than 0"
     * )
     * 
     * @Expose
     */
    private $price;

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
     * @var array
     * 
     * @ORM\OneToMany(targetEntity="ApiBundle\Entity\Option", mappedBy="car", cascade={"remove, persist"})
     * 
     * @Expose
     */
    private $option;
    
    /**
     * @var array
     * 
     * @ORM\OneToMany(targetEntity="ApiBundle\Entity\Equipment", mappedBy="car", cascade={"remove, persist"})
     * 
     * @Expose
     */
    private $equipment;


    /**
     * Set maker
     *
     * @param string $maker
     *
     * @return Car
     */
    public function setMaker($maker)
    {
        $this->maker = $maker;

        return $this;
    }

    /**
     * Get maker
     *
     * @return string
     */
    public function getMaker()
    {
        return $this->maker;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Car
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Car
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Car
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
     * @return Car
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
     * Set id
     *
     * @return Car
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
        
    }
    
    /**
     * Get option
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOption()
    {
        return $this->option;
    }
    
        
    /**
     * Add option
     *
     * @param \ApiBundle\Entity\Option $option
     * @return Car
     */
    public function addOption(Option $option)
    {
        $option->setCar($this);
        $this->option[] = $option;
    
        return $this;
    }

    /**
     * Remove option
     *
     * @param \ApiBundle\Entity\Option $option
     */
    public function removeOption(Option $option)
    {
        $this->option->removeElement($option);
    }



    /**
     * Get equipment
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Add equipment
     *
     * @param \ApiBundle\Entity\Equipment $equipment
     *
     * @return Car
     */
    public function addEquipment(\ApiBundle\Entity\Equipment $equipment)
    {
        $equipment->setCar($this);
        $this->equipment[] = $equipment;

        return $this;
    }
    
    /**
     * Remove equipment
     *
     * @param \ApiBundle\Entity\Equipment $equipment
     */
    public function removeEquipment(\ApiBundle\Entity\Equipment $equipment)
    {
        $this->equipment->removeElement($equipment);
    }

}
