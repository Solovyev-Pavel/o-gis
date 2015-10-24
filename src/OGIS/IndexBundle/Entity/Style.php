<?php

namespace OGIS\IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_styles")
 */
class Style
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
	 * @ORM\Column(type="string", length=64, nullable=false, unique=true)
	 */
	private $internalname;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="styles", fetch="EAGER")
	 */
	private $author;

	/**
	 * @ORM\Column(type="text")
	 */
	private $data;

	/**
	 * @ORM\Column(type="string", length=8, unique=false)
	 */
	private $type;

	/**
	 * @ORM\Column(type="string", length=1024)
	 */
	private $description;

	/**
	 * @ORM\Column(type="date")
	 */
	private $created;

	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	private $modified;

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
     * @return Style
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
     * Set data
     *
     * @param string $data
     * @return Style
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Style
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
     * Set preview
     *
     * @param string $preview
     * @return Style
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;

        return $this;
    }

    /**
     * Get preview
     *
     * @return string 
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Style
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
     * Set modified
     *
     * @param \DateTime $modified
     * @return Style
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
     * Set public
     *
     * @param boolean $public
     * @return Style
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
     * Set rating_points
     *
     * @param integer $ratingPoints
     * @return Style
     */
    public function setRatingPoints($ratingPoints)
    {
        $this->rating_points = $ratingPoints;

        return $this;
    }

    /**
     * Get rating_points
     *
     * @return integer 
     */
    public function getRatingPoints()
    {
        return $this->rating_points;
    }

    /**
     * Set ratings_given
     *
     * @param integer $ratingsGiven
     * @return Style
     */
    public function setRatingsGiven($ratingsGiven)
    {
        $this->ratings_given = $ratingsGiven;

        return $this;
    }

    /**
     * Get ratings_given
     *
     * @return integer 
     */
    public function getRatingsGiven()
    {
        return $this->ratings_given;
    }

    /**
     * Set author
     *
     * @param \OGIS\IndexBundle\Entity\User $author
     * @return Style
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
     * Set type
     *
     * @param string $type
     * @return Style
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set internalname
     *
     * @param string $internalname
     * @return Style
     */
    public function setInternalname($internalname)
    {
        $this->internalname = $internalname;

        return $this;
    }

    /**
     * Get internalname
     *
     * @return string 
     */
    public function getInternalname()
    {
        return $this->internalname;
    }
}
