<?php

namespace OGIS\IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_layers")
 */
class Layer {

/* ********************************* Simple properties **************************** */

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=256, nullable=false, unique=false)
	 */
	private $name;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="layers", fetch="EAGER")
	 */
	private $author;

	/**
	 * @ORM\Column(type="string", length=2048)
	 */
	private $description;

	/**
	 * @ORM\Column(type="string", length=8, nullable=false)
	 */
	private $type;

/* ********************************* System properties **************************** */

	/**
	 * @ORM\Column(type="string", length=32)
	 */
	private $workspace;

	/**
	 * @ORM\Column(type="string", length=256)
	 */
	private $con_string;

	/**
	 * @ORM\Column(type="string", length=256)
	 */
	private $preview;
        
        /**
	 * @ORM\ManyToOne(targetEntity="Style", fetch="EAGER")
	 */
	private $style;
        
        /**
         * @ORM\Column(type="string", length=1024, nullable=true)
         */
        private $palette;

	/**
	 * @ORM\Column(type="date")
	 */
	private $created;

	/**
	 * @ORM\Column(type="date")
	 */
	private $modified;

	/**
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	private $public = true;

	/**
	 * @ORM\Column(type="bigint", nullable=true)
	 */
	private $size;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $views;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $downloads;

/* ********************************** Data properties ***************************** */

	/**
	 * @ORM\Column(type="string", length=16, nullable=false)
	 */
	private $projection;

	/**
	 * @ORM\Column(type="string", length=16, nullable=false)
	 */
	private $format;

	/**
	 * @ORM\Column(type="string", length=32, nullable=true)
	 */
	private $datatype;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $resolutionX;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $resolutionY;

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

	/**
	 * @ORM\Column(type="float", nullable=true)
	 */
	private $minvalue;

	/**
	 * @ORM\Column(type="float", nullable=true)
	 */
	private $maxvalue;

	/**
	 * @ORM\Column(type="float", nullable=true)
	 */
	private $nodatavalue;

/* ********************************* Array'd properties *************************** */

	/**
	 * @ORM\ManyToMany(targetEntity="Composition", inversedBy="layers", fetch="LAZY")
	 */
	private $compositions;

/* *************************************** Methods ******************************** */

    public function __construct()
    {
	$this->compositions = new ArrayCollection();
    }

   // return all compositions where this layer is used
    public function getCompositions() { return $this->compositions->toArray(); }

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
     * @return Layer
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
     * @return Layer
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
     * Set type
     *
     * @param string $type
     * @return Layer
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
     * Set con_string
     *
     * @param string $conString
     * @return Layer
     */
    public function setConString($conString)
    {
        $this->con_string = $conString;

        return $this;
    }

    /**
     * Get con_string
     *
     * @return string 
     */
    public function getConString()
    {
        return $this->con_string;
    }

    /**
     * Set preview
     *
     * @param string $preview
     * @return Layer
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
     * @return Layer
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
     * @return Layer
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
     * @return Layer
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
     * Set views
     *
     * @param integer $views
     * @return Layer
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
     * Set downloads
     *
     * @param integer $downloads
     * @return Layer
     */
    public function setDownloads($downloads)
    {
        $this->downloads = $downloads;

        return $this;
    }

    /**
     * Get downloads
     *
     * @return integer 
     */
    public function getDownloads()
    {
        return $this->downloads;
    }

    /**
     * Set projection
     *
     * @param string $projection
     * @return Layer
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
     * Set resolutionX
     *
     * @param integer $resolutionX
     * @return Layer
     */
    public function setResolutionX($resolutionX)
    {
        $this->resolutionX = $resolutionX;

        return $this;
    }

    /**
     * Get resolutionX
     *
     * @return integer 
     */
    public function getResolutionX()
    {
        return $this->resolutionX;
    }

    /**
     * Set resolutionY
     *
     * @param integer $resolutionY
     * @return Layer
     */
    public function setResolutionY($resolutionY)
    {
        $this->resolutionY = $resolutionY;

        return $this;
    }

    /**
     * Get resolutionY
     *
     * @return integer 
     */
    public function getResolutionY()
    {
        return $this->resolutionY;
    }

    /**
     * Set boundingBoxMinX
     *
     * @param integer $boundingBoxMinX
     * @return Layer
     */
    public function setBoundingBoxMinX($boundingBoxMinX)
    {
        $this->boundingBoxMinX = $boundingBoxMinX;

        return $this;
    }

    /**
     * Get boundingBoxMinX
     *
     * @return integer 
     */
    public function getBoundingBoxMinX()
    {
        return $this->boundingBoxMinX;
    }

    /**
     * Set boundingBoxMinY
     *
     * @param integer $boundingBoxMinY
     * @return Layer
     */
    public function setBoundingBoxMinY($boundingBoxMinY)
    {
        $this->boundingBoxMinY = $boundingBoxMinY;

        return $this;
    }

    /**
     * Get boundingBoxMinY
     *
     * @return integer 
     */
    public function getBoundingBoxMinY()
    {
        return $this->boundingBoxMinY;
    }

    /**
     * Set boundingBoxMaxX
     *
     * @param integer $boundingBoxMaxX
     * @return Layer
     */
    public function setBoundingBoxMaxX($boundingBoxMaxX)
    {
        $this->boundingBoxMaxX = $boundingBoxMaxX;

        return $this;
    }

    /**
     * Get boundingBoxMaxX
     *
     * @return integer 
     */
    public function getBoundingBoxMaxX()
    {
        return $this->boundingBoxMaxX;
    }

    /**
     * Set boundingBoxMaxY
     *
     * @param integer $boundingBoxMaxY
     * @return Layer
     */
    public function setBoundingBoxMaxY($boundingBoxMaxY)
    {
        $this->boundingBoxMaxY = $boundingBoxMaxY;

        return $this;
    }

    /**
     * Get boundingBoxMaxY
     *
     * @return integer 
     */
    public function getBoundingBoxMaxY()
    {
        return $this->boundingBoxMaxY;
    }

    /**
     * Set author
     *
     * @param \OGIS\IndexBundle\Entity\User $author
     * @return Layer
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
     * Add compositions
     *
     * @param \OGIS\IndexBundle\Entity\Composition $compositions
     * @return Layer
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
     * Set size
     *
     * @param integer $size
     * @return Layer
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set format
     *
     * @param string $format
     * @return Layer
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format
     *
     * @return string 
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set datatype
     *
     * @param string $datatype
     * @return Layer
     */
    public function setDatatype($datatype)
    {
        $this->datatype = $datatype;

        return $this;
    }

    /**
     * Get datatype
     *
     * @return string 
     */
    public function getDatatype()
    {
        return $this->datatype;
    }

    /**
     * Set minvalue
     *
     * @param float $minvalue
     * @return Layer
     */
    public function setMinvalue($minvalue)
    {
        $this->minvalue = $minvalue;

        return $this;
    }

    /**
     * Get minvalue
     *
     * @return float
     */
    public function getMinvalue()
    {
        return $this->minvalue;
    }

    /**
     * Set maxvalue
     *
     * @param float $maxvalue
     * @return Layer
     */
    public function setMaxvalue($maxvalue)
    {
        $this->maxvalue = $maxvalue;

        return $this;
    }

    /**
     * Get maxvalue
     *
     * @return float
     */
    public function getMaxvalue()
    {
        return $this->maxvalue;
    }

    /**
     * Set nodatavalue
     *
     * @param float $nodatavalue
     * @return Layer
     */
    public function setNodatavalue($nodatavalue)
    {
        $this->nodatavalue = $nodatavalue;

        return $this;
    }

    /**
     * Get nodatavalue
     *
     * @return float
     */
    public function getNodatavalue()
    {
        return $this->nodatavalue;
    }

    /**
     * Set workspace
     *
     * @param string $workspace
     * @return Layer
     */
    public function setWorkspace($workspace)
    {
        $this->workspace = $workspace;

        return $this;
    }

    /**
     * Get workspace
     *
     * @return string 
     */
    public function getWorkspace()
    {
        return $this->workspace;
    }

    /**
     * Set style
     *
     * @param \OGIS\IndexBundle\Entity\Style $style
     * @return Layer
     */
    public function setStyle(\OGIS\IndexBundle\Entity\Style $style = null)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return \OGIS\IndexBundle\Entity\Style 
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set palette
     *
     * @param string $palette
     * @return Layer
     */
    public function setPalette($palette)
    {
        $this->palette = $palette;

        return $this;
    }

    /**
     * Get palette
     *
     * @return string 
     */
    public function getPalette()
    {
        return $this->palette;
    }
}
