<?php

namespace OGIS\IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_palettes")
 */
class Palette{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=64, nullable=false, unique=false)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=1024, nullable=true, unique=false)
	 */
	private $description;

	/**
	 * @ORM\Column(type="string", length=2048)
	 */
	private $colors;

	/**
	 * @ORM\Column(type="string", length=1280)
	 */
	private $keyValues;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="palettes", fetch="EAGER")
	 */
	private $author;

	/**
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	private $public = true;


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
     * @return Palette
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
     * @return Palette
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
     * Set colors
     *
     * @param string $colors
     * @return Palette
     */
    public function setColors($colors)
    {
        $this->colors = $colors;

        return $this;
    }

    /**
     * Get colors
     *
     * @return string 
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * Set keyValues
     *
     * @param string $keyValues
     * @return Palette
     */
    public function setKeyValues($keyValues)
    {
        $this->keyValues = $keyValues;

        return $this;
    }

    /**
     * Get keyValues
     *
     * @return string 
     */
    public function getKeyValues()
    {
        return $this->keyValues;
    }

    /**
     * Set author
     *
     * @param \OGIS\IndexBundle\Entity\User $author
     * @return Palette
     */
    public function setAuthor(\OGIS\IndexBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \OGIS\IndexBundle\Entity\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set public
     *
     * @param boolean $public
     * @return Palette
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
}
