<?php

namespace OGIS\IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_compositions")
 */
class Composition
{

/* ********************************* Simple properties **************************** */
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
	 * @ORM\Column(type="string", length=2048)
	 */
	private $description;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="compositions", fetch="EAGER")
	 */
	private $author;

/* ********************************** System properties ***************************** */

	/**
	 * @ORM\Column(type="text")
	 */
	private $data;

	/**
	 * @ORM\Column(type="string", length=256)
	 */
	private $preview;

	/**
	 * @ORM\Column(type="date")
	 */
	private $created;

	/**
	 * @ORM\Column(type="date")
	 */
	private $modified;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $public = true;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $views;

/* ********************************** Data properties ***************************** */

	/**
	 * @ORM\Column(type="string", length=16, nullable=false)
	 */
	private $projection;

	/**
	 * @ORM\Column(type="float")
	 */
	private $boundingBoxMinX;

	/**
	 * @ORM\Column(type="float")
	 */
	private $boundingBoxMinY;

	/**
	 * @ORM\Column(type="float")
	 */
	private $boundingBoxMaxX;

	/**
	 * @ORM\Column(type="float")
	 */
	private $boundingBoxMaxY;

/* ********************************* Array'd properties *************************** */

	/**
	 * @ORM\ManyToMany(targetEntity="Layer", mappedBy="compositions", fetch="LAZY")
	 */
	private $layers;


    public function __construct()
    {
	$this->layers = new ArrayCollection();
    }

   // return all layers associated with this composition
    public function getLayers() { return $this->layers->toArray(); }

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
     * @return Composition
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
     * @return Composition
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
     * Set data
     *
     * @param string $data
     * @return Composition
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
     * Set preview
     *
     * @param string $preview
     * @return Composition
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
     * @return Composition
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
     * @return Composition
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
     * @return Composition
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
     * @return Composition
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
     * @return Composition
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
     * @return Composition
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
     * Set project
     *
     * @param \OGIS\IndexBundle\Entity\Project $project
     * @return Composition
     */
    public function setProject(\OGIS\IndexBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \OGIS\IndexBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set layers
     *
     * @param \OGIS\IndexBundle\Entity\Layer $layers
     * @return Composition
     */
    public function setLayers(\OGIS\IndexBundle\Entity\Layer $layers = null)
    {
        $this->layers = $layers;

        return $this;
    }

    /**
     * Set views
     *
     * @param integer $views
     * @return Composition
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer 
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Add layers
     *
     * @param \OGIS\IndexBundle\Entity\Layer $layers
     * @return Composition
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
     * Set projection
     *
     * @param string $projection
     * @return Composition
     */
    public function setProjection($projection)
    {
        $this->projection = $projection;

        return $this;
    }

    /**
     * Get projection
     *
     * @return string 
     */
    public function getProjection()
    {
        return $this->projection;
    }

    /**
     * Set boundingBoxMinX
     *
     * @param float $boundingBoxMinX
     * @return Composition
     */
    public function setBoundingBoxMinX($boundingBoxMinX)
    {
        $this->boundingBoxMinX = $boundingBoxMinX;

        return $this;
    }

    /**
     * Get boundingBoxMinX
     *
     * @return float 
     */
    public function getBoundingBoxMinX()
    {
        return $this->boundingBoxMinX;
    }

    /**
     * Set boundingBoxMinY
     *
     * @param float $boundingBoxMinY
     * @return Composition
     */
    public function setBoundingBoxMinY($boundingBoxMinY)
    {
        $this->boundingBoxMinY = $boundingBoxMinY;

        return $this;
    }

    /**
     * Get boundingBoxMinY
     *
     * @return float 
     */
    public function getBoundingBoxMinY()
    {
        return $this->boundingBoxMinY;
    }

    /**
     * Set boundingBoxMaxX
     *
     * @param float $boundingBoxMaxX
     * @return Composition
     */
    public function setBoundingBoxMaxX($boundingBoxMaxX)
    {
        $this->boundingBoxMaxX = $boundingBoxMaxX;

        return $this;
    }

    /**
     * Get boundingBoxMaxX
     *
     * @return float 
     */
    public function getBoundingBoxMaxX()
    {
        return $this->boundingBoxMaxX;
    }

    /**
     * Set boundingBoxMaxY
     *
     * @param float $boundingBoxMaxY
     * @return Composition
     */
    public function setBoundingBoxMaxY($boundingBoxMaxY)
    {
        $this->boundingBoxMaxY = $boundingBoxMaxY;

        return $this;
    }

    /**
     * Get boundingBoxMaxY
     *
     * @return float 
     */
    public function getBoundingBoxMaxY()
    {
        return $this->boundingBoxMaxY;
    }
}
