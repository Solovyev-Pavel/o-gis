<?php

namespace OGIS\IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_roles")
 */
class Role
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=32, unique=true, nullable=false)
	 */
	protected $role;

	/**
	 * @ORM\Column(type="string", length=128, nullable=false, unique=true)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $layers;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $styles;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $palettes;


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
     * Set role
     *
     * @param string $role
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Role
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
     * Set layers
     *
     * @param integer $layers
     * @return Role
     */
    public function setLayers($layers)
    {
        $this->layers = $layers;

        return $this;
    }

    /**
     * Get layers
     *
     * @return integer 
     */
    public function getLayers()
    {
        return $this->layers;
    }

    /**
     * Set styles
     *
     * @param integer $styles
     * @return Role
     */
    public function setStyles($styles)
    {
        $this->styles = $styles;

        return $this;
    }

    /**
     * Get styles
     *
     * @return integer 
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * Set palettes
     *
     * @param integer $palettes
     * @return Role
     */
    public function setPalettes($palettes)
    {
        $this->palettes = $palettes;

        return $this;
    }

    /**
     * Get palettes
     *
     * @return integer 
     */
    public function getPalettes()
    {
        return $this->palettes;
    }
}
