<?php
namespace OGIS\IndexBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_links")
 */
class Link {
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	/**
	 * @ORM\ManyToOne(targetEntity="Catalog", inversedBy="links")
	 */
	private $catalog;
	/**
	 * @ORM\Column(type="string", length=32, nullable=false)
	 */
	private $targetType;
	/**
	 * @ORM\Column(type="string", length=256)
	 */
	private $targetTitle;
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $targetId;
	/**
	 * @ORM\Column(type="string", length=256, nullable=true)
	 */
	private $targetUrl;
	/**
	 * @ORM\Column(type="string", length=512)
	 */
	private $extraInfo;
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
     * Set targetType
     *
     * @param string $targetType
     * @return Link
     */
    public function setTargetType($targetType)
    {
        $this->targetType = $targetType;
        return $this;
    }
    /**
     * Get targetType
     *
     * @return string 
     */
    public function getTargetType()
    {
        return $this->targetType;
    }
    /**
     * Set targetTitle
     *
     * @param string $targetTitle
     * @return Link
     */
    public function setTargetTitle($targetTitle)
    {
        $this->targetTitle = $targetTitle;
        return $this;
    }
    /**
     * Get targetTitle
     *
     * @return string 
     */
    public function getTargetTitle()
    {
        return $this->targetTitle;
    }
    /**
     * Set targetId
     *
     * @param integer $targetId
     * @return Link
     */
    public function setTargetId($targetId)
    {
        $this->targetId = $targetId;
        return $this;
    }
    /**
     * Get targetId
     *
     * @return integer 
     */
    public function getTargetId()
    {
        return $this->targetId;
    }
    /**
     * Set targetUrl
     *
     * @param string $targetUrl
     * @return Link
     */
    public function setTargetUrl($targetUrl)
    {
        $this->targetUrl = $targetUrl;
        return $this;
    }
    /**
     * Get targetUrl
     *
     * @return string 
     */
    public function getTargetUrl()
    {
        return $this->targetUrl;
    }
    /**
     * Set catalog
     *
     * @param \OGIS\IndexBundle\Entity\Catalog $catalog
     * @return Link
     */
    public function setCatalog(\OGIS\IndexBundle\Entity\Catalog $catalog = null)
    {
        $this->catalog = $catalog;
        return $this;
    }
    /**
     * Get catalog
     *
     * @return \OGIS\IndexBundle\Entity\Catalog 
     */
    public function getCatalog()
    {
        return $this->catalog;
    }
    /**
     * Set extraInfo
     *
     * @param string $extraInfo
     * @return Link
     */
    public function setExtraInfo($extraInfo)
    {
        $this->extraInfo = $extraInfo;
        return $this;
    }
    /**
     * Get extraInfo
     *
     * @return string 
     */
    public function getExtraInfo()
    {
        return $this->extraInfo;
    }
}
