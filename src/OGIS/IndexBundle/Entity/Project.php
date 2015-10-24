<?php

namespace OGIS\IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_projects")
 */
class Project
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=64, nullable=false, unique=true)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=1024)
	 */
	private $description;

	/**
	 * @ORM\OneToMany(targetEntity="ProjectParticipation", mappedBy="project", fetch="LAZY", orphanRemoval=true, cascade={"persist","remove"})
	 */
	private $participants;

	/**
	 * @ORM\Column(type="date")
	 */
	private $created;
        
        /**
	 * @ORM\Column(type="guid")
	 */
	private $catalog;

	/**
	 * @ORM\Column(type="date")
	 */
	private $modified;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $publicviewable = true;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $publicjoinable = true;

    public function __construct()
    {
	$this->participants = new ArrayCollection();
    }

   // return all compositions where this layer is used
    public function getParticipants() { return $this->participants->toArray(); }

    /**
     * Add user
     *
     * @param \OGIS\IndexBundle\Entity\ProjectParticipation $participants
     * @return User
     */
    public function addParticipants(\OGIS\IndexBundle\Entity\ProjectParticipation $participants)
    {
        $this->participants[] = $participants;
        $participants->setUser($this);
        return $this;
    }

   /**
     * Remove participants
     *
     * @param \OGIS\IndexBundle\Entity\ProjectParticipation $participants
     */
    public function removeParticipant(\OGIS\IndexBundle\Entity\ProjectParticipation $participants)
    {
        $this->projects->removeElement($participants);
        $participants->setProject(null);
    }

    // shorthand to get all projects a user is involved in
    public function getProjectsUsers(){
        return array_map(

            function($user){
                return $user->getProject();
            },
            $this->participants->toArray()

        );
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
     * Set name
     *
     * @param string $name
     * @return Project
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
     * Set description
     *
     * @param string $description
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Project
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set catalog
     *
     * @param guid $catalog
     * @return Project
     */
    public function setCatalog($catalog)
    {
        $this->catalog = $catalog;

        return $this;
    }

    /**
     * Get catalog
     *
     * @return guid 
     */
    public function getCatalog()
    {
        return $this->catalog;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     * @return Project
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime 
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set publicviewable
     *
     * @param boolean $publicviewable
     * @return Project
     */
    public function setPublicviewable($publicviewable)
    {
        $this->publicviewable = $publicviewable;

        return $this;
    }

    /**
     * Get publicviewable
     *
     * @return boolean 
     */
    public function getPublicviewable()
    {
        return $this->publicviewable;
    }

    /**
     * Set publicjoinable
     *
     * @param boolean $publicjoinable
     * @return Project
     */
    public function setPublicjoinable($publicjoinable)
    {
        $this->publicjoinable = $publicjoinable;

        return $this;
    }

    /**
     * Get publicjoinable
     *
     * @return boolean 
     */
    public function getPublicjoinable()
    {
        return $this->publicjoinable;
    }

    /**
     * Add participants
     *
     * @param \OGIS\IndexBundle\Entity\ProjectParticipation $participants
     * @return Project
     */
    public function addParticipant(\OGIS\IndexBundle\Entity\ProjectParticipation $participants)
    {
        $this->participants[] = $participants;

        return $this;
    }
}
