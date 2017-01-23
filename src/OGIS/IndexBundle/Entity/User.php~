<?php

namespace OGIS\IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_users")
 * @ORM\Entity(repositoryClass="OGIS\IndexBundle\Entity\UserRepository")
 */
class User extends BaseUser {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=128, nullable=true)
	 */
	protected $displayname;
        
        /**
         * @ORM\Column(type="text", nullable=true)
         */
        protected $messageboard;

	/**
        * @ORM\OneToMany(targetEntity="Layer", mappedBy="author", fetch="LAZY")
	 */
	protected $layers;

	/**
        * @ORM\OneToMany(targetEntity="Composition", mappedBy="author", fetch="LAZY")
	 */
	protected $compositions;

	/**
        * @ORM\OneToMany(targetEntity="Style", mappedBy="author", fetch="LAZY")
	 */
	protected $styles;

	/**
        * @ORM\OneToMany(targetEntity="ProjectParticipation", mappedBy="user", fetch="LAZY", orphanRemoval=true, cascade={"persist","remove"})
	 */
	protected $projects;

	/**
	 * @ORM\OneToMany(targetEntity="Palette", mappedBy="author", fetch="LAZY")
	 */
	protected $palettes;

	/**
	 * @ORM\ManyToMany(targetEntity="Catalog", mappedBy="owner", fetch="LAZY")
	 */
	private $catalogs;
        
/* ********************** Messages ********************** */
        
        /**
         * @ORM\OneToMany(targetEntity="Message", mappedBy="sender", fetch="LAZY")
	 */
	protected $messagesSent;
        
        /**
         * @ORM\OneToMany(targetEntity="Message", mappedBy="addressee", fetch="LAZY")
	 */
	protected $messagesReceived;

/* *********************** Limits *********************** */

	/**
	 * @ORM\ManyToOne(targetEntity="Role")
	 * @ORM\JoinColumn(referencedColumnName="id")
	 **/
	private $limits;

/* *********************** Methods *********************** */

	public function __construct() {
		parent::__construct();
		$this->layers = new ArrayCollection();
		$this->compositions = new ArrayCollection();
		$this->styles = new ArrayCollection();
		$this->catalogs = new ArrayCollection();
		$this->projects = new ArrayCollection();
		$this->palettes = new ArrayCollection();
                $this->messagesSent = new ArrayCollection();
                $this->messagesReceived = new ArrayCollection();
	}


	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * Get layers
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getLayers(){
		return $this->layers->toArray();
	}

	/**
	 * Get compositions
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getCompositions(){
		return $this->compositions->toArray();
	}

	/**
	 * Get styles
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getStyles(){
		return $this->styles->toArray();
	}

	/**
	 * Get catalogs
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getCatalogs(){
		return $this->catalogs->toArray();
	}

	/**
	 * Get projects
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getProjects(){
		return $this->projects->toArray();
	}

	/**
	 * Get palettes
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getPalettes(){
		return $this->palettes->toArray();
	}

        /**
	 * Get messagesSent
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getMessagesSent(){
		return $this->messagesSent->toArray();
	}
        
        /**
	 * Get messagesReceived
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getMessagesReceived(){
		return $this->messagesReceived->toArray();
	}
        

    /**
     * Set displayname
     *
     * @param string $displayname
     * @return User
     */
    public function setDisplayname($displayname)
    {
        $this->displayname = $displayname;

        return $this;
    }

    /**
     * Get displayname
     *
     * @return string 
     */
    public function getDisplayname()
    {
        return $this->displayname;
    }

    /**
     * Add layers
     *
     * @param \OGIS\IndexBundle\Entity\Layer $layers
     * @return User
     */
    public function addLayer(\OGIS\IndexBundle\Entity\Layer $layers)
    {
        $this->layers[] = $layers;

        return $this;
    }

    /**
     * Remove layers
     *
     * @param \OGIS\IndexBundle\Entity\Layer $layers
     */
    public function removeLayer(\OGIS\IndexBundle\Entity\Layer $layers)
    {
        $this->layers->removeElement($layers);
    }

    /**
     * Add compositions
     *
     * @param \OGIS\IndexBundle\Entity\Composition $compositions
     * @return User
     */
    public function addComposition(\OGIS\IndexBundle\Entity\Composition $compositions)
    {
        $this->compositions[] = $compositions;

        return $this;
    }

    /**
     * Remove compositions
     *
     * @param \OGIS\IndexBundle\Entity\Composition $compositions
     */
    public function removeComposition(\OGIS\IndexBundle\Entity\Composition $compositions)
    {
        $this->compositions->removeElement($compositions);
    }

    /**
     * Add styles
     *
     * @param \OGIS\IndexBundle\Entity\Style $styles
     * @return User
     */
    public function addStyle(\OGIS\IndexBundle\Entity\Style $styles)
    {
        $this->styles[] = $styles;

        return $this;
    }

    /**
     * Remove styles
     *
     * @param \OGIS\IndexBundle\Entity\Style $styles
     */
    public function removeStyle(\OGIS\IndexBundle\Entity\Style $styles)
    {
        $this->styles->removeElement($styles);
    }

    /**
     * Add projects
     *
     * @param \OGIS\IndexBundle\Entity\ProjectParticipation $projects
     * @return User
     */
    public function addProject(\OGIS\IndexBundle\Entity\ProjectParticipation $projects)
    {
        $this->projects[] = $projects;
        $projects->setUser($this);
        return $this;
    }

    /**
     * Remove projects
     *
     * @param \OGIS\IndexBundle\Entity\ProjectParticipation $projects
     */
    public function removeProject(\OGIS\IndexBundle\Entity\ProjectParticipation $projects)
    {
        $this->projects->removeElement($projects);
        $projects->setUser(null);
    }

    // shorthand to get all projects a user is involved in
    public function getUsersProjects(){
        return array_map(

            function($project){
                return $project->getProject();
            },
            $this->projects->toArray()

        );
    }

    /**
     * Add catalogs
     *
     * @param \OGIS\IndexBundle\Entity\Catalog $catalogs
     * @return User
     */
    public function addCatalog(\OGIS\IndexBundle\Entity\Catalog $catalogs)
    {
        $this->catalogs[] = $catalogs;

        return $this;
    }

    /**
     * Remove catalogs
     *
     * @param \OGIS\IndexBundle\Entity\Catalog $catalogs
     */
    public function removeCatalog(\OGIS\IndexBundle\Entity\Catalog $catalogs)
    {
        $this->catalogs->removeElement($catalogs);
    }

    /**
     * Set limits
     *
     * @param \OGIS\IndexBundle\Entity\Role $limits
     * @return User
     */
    public function setLimits(\OGIS\IndexBundle\Entity\Role $limits = null)
    {
        $this->limits = $limits;

        return $this;
    }

    /**
     * Get limits
     *
     * @return \OGIS\IndexBundle\Entity\Role 
     */
    public function getLimits()
    {
        return $this->limits;
    }

    /**
     * Add palettes
     *
     * @param \OGIS\IndexBundle\Entity\Palette $palettes
     * @return User
     */
    public function addPalette(\OGIS\IndexBundle\Entity\Palette $palettes)
    {
        $this->palettes[] = $palettes;

        return $this;
    }

    /**
     * Remove palettes
     *
     * @param \OGIS\IndexBundle\Entity\Palette $palettes
     */
    public function removePalette(\OGIS\IndexBundle\Entity\Palette $palettes)
    {
        $this->palettes->removeElement($palettes);
    }

    /**
     * Set messageboard
     *
     * @param string $messageboard
     * @return User
     */
    public function setMessageboard($messageboard)
    {
        $this->messageboard = $messageboard;

        return $this;
    }

    /**
     * Get messageboard
     *
     * @return string 
     */
    public function getMessageboard()
    {
        return $this->messageboard;
    }

    /**
     * Add messagesSent
     *
     * @param \OGIS\IndexBundle\Entity\Message $messagesSent
     * @return User
     */
    public function addMessagesSent(\OGIS\IndexBundle\Entity\Message $messagesSent)
    {
        $this->messagesSent[] = $messagesSent;

        return $this;
    }

    /**
     * Remove messagesSent
     *
     * @param \OGIS\IndexBundle\Entity\Message $messagesSent
     */
    public function removeMessagesSent(\OGIS\IndexBundle\Entity\Message $messagesSent)
    {
        $this->messagesSent->removeElement($messagesSent);
    }

    /**
     * Add messagesReceived
     *
     * @param \OGIS\IndexBundle\Entity\Message $messagesReceived
     * @return User
     */
    public function addMessagesReceived(\OGIS\IndexBundle\Entity\Message $messagesReceived)
    {
        $this->messagesReceived[] = $messagesReceived;

        return $this;
    }

    /**
     * Remove messagesReceived
     *
     * @param \OGIS\IndexBundle\Entity\Message $messagesReceived
     */
    public function removeMessagesReceived(\OGIS\IndexBundle\Entity\Message $messagesReceived)
    {
        $this->messagesReceived->removeElement($messagesReceived);
    }
}
