<?php

namespace OGIS\IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_catalogues")
 */
class Catalog {

/* ************************************ class properties ********************************* */

	/**
	 * @ORM\Column(type="guid")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="UUID")
	 */
	private $id;

	/**
	 * @ORM\ManyToMany(targetEntity="User", inversedBy="catalogs")
	 */
	private $owner;

	/**
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	private $public = true;
        
        /**
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	private $global = false;

	/**
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	private $project = false;

	/**
	 * @ORM\Column(type="string", length=256, nullable=false)
	 */
	private $title;

	/**
        * @ORM\OneToMany(targetEntity="Link", mappedBy="catalog", fetch="LAZY")
	 */
	protected $links;

	/**
	 * @ORM\ManyToMany(targetEntity="Catalog")
	 * @ORM\JoinTable(name="catalog_catalog",
	 *     joinColumns={@ORM\JoinColumn(name="parent_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="child_id", referencedColumnName="id")}
	 * )
	 * @var \Doctrine\Common\Collections\ArrayCollection
	 */
	protected $children;

	/**
	 * @ORM\Column(type="guid", nullable=true)
	 */
	private $parent;

/* ************************************** class methods *********************************** */

	public function __construct(){
		$this->links = new ArrayCollection();
		$this->children = new ArrayCollection();
	}

	public function getChildren(){
		return $this->children->toArray();
	}

	public function getLinks(){
		return $this->links->toArray();
	}
	
    /**
     * Set id
     *
     * @param guid $id
     * @return Catalog
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
        
    /**
     * Get id
     *
     * @return guid 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set public
     *
     * @param boolean $public
     * @return Catalog
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return boolean 
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Catalog
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set owner
     *
     * @param \OGIS\IndexBundle\Entity\User $owner
     * @return Catalog
     */
    public function setOwner(\OGIS\IndexBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \OGIS\IndexBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add links
     *
     * @param \OGIS\IndexBundle\Entity\Link $links
     * @return Catalog
     */
    public function addLink(\OGIS\IndexBundle\Entity\Link $links)
    {
        $this->links[] = $links;

        return $this;
    }

    /**
     * Remove links
     *
     * @param \OGIS\IndexBundle\Entity\Link $links
     */
    public function removeLink(\OGIS\IndexBundle\Entity\Link $links)
    {
        $this->links->removeElement($links);
    }

    /**
     * Add children
     *
     * @param \OGIS\IndexBundle\Entity\Catalog $children
     * @return Catalog
     */
    public function addChild(\OGIS\IndexBundle\Entity\Catalog $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \OGIS\IndexBundle\Entity\Catalog $children
     */
    public function removeChild(\OGIS\IndexBundle\Entity\Catalog $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Set project
     *
     * @param boolean $project
     * @return Catalog
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return boolean 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set parent
     *
     * @param guid $parent
     * @return Catalog
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return guid 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add owner
     *
     * @param \OGIS\IndexBundle\Entity\User $owner
     * @return Catalog
     */
    public function addOwner(\OGIS\IndexBundle\Entity\User $owner)
    {
        $this->owner[] = $owner;

        return $this;
    }

    /**
     * Remove owner
     *
     * @param \OGIS\IndexBundle\Entity\User $owner
     */
    public function removeOwner(\OGIS\IndexBundle\Entity\User $owner)
    {
        $this->owner->removeElement($owner);
    }

    /**
     * Set global
     *
     * @param boolean $global
     * @return Catalog
     */
    public function setGlobal($global)
    {
        $this->global = $global;

        return $this;
    }

    /**
     * Get global
     *
     * @return boolean 
     */
    public function getGlobal()
    {
        return $this->global;
    }
}
