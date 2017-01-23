<?php

namespace Proxies\__CG__\OGIS\IndexBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Composition extends \OGIS\IndexBundle\Entity\Composition implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'id', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'name', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'description', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'author', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'data', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'preview', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'created', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'modified', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'public', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'views', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'projection', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'boundingBoxMinX', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'boundingBoxMinY', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'boundingBoxMaxX', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'boundingBoxMaxY', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'layers');
        }

        return array('__isInitialized__', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'id', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'name', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'description', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'author', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'data', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'preview', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'created', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'modified', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'public', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'views', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'projection', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'boundingBoxMinX', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'boundingBoxMinY', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'boundingBoxMaxX', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'boundingBoxMaxY', '' . "\0" . 'OGIS\\IndexBundle\\Entity\\Composition' . "\0" . 'layers');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Composition $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getLayers()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLayers', array());

        return parent::getLayers();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', array($name));

        return parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', array());

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function setDescription($description)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescription', array($description));

        return parent::setDescription($description);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescription', array());

        return parent::getDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function setData($data)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setData', array($data));

        return parent::setData($data);
    }

    /**
     * {@inheritDoc}
     */
    public function getData()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getData', array());

        return parent::getData();
    }

    /**
     * {@inheritDoc}
     */
    public function setPreview($preview)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPreview', array($preview));

        return parent::setPreview($preview);
    }

    /**
     * {@inheritDoc}
     */
    public function getPreview()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPreview', array());

        return parent::getPreview();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreated($created)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreated', array($created));

        return parent::setCreated($created);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreated()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreated', array());

        return parent::getCreated();
    }

    /**
     * {@inheritDoc}
     */
    public function setModified($modified)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModified', array($modified));

        return parent::setModified($modified);
    }

    /**
     * {@inheritDoc}
     */
    public function getModified()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModified', array());

        return parent::getModified();
    }

    /**
     * {@inheritDoc}
     */
    public function setPublic($public)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPublic', array($public));

        return parent::setPublic($public);
    }

    /**
     * {@inheritDoc}
     */
    public function getPublic()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPublic', array());

        return parent::getPublic();
    }

    /**
     * {@inheritDoc}
     */
    public function setRatingPoints($ratingPoints)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRatingPoints', array($ratingPoints));

        return parent::setRatingPoints($ratingPoints);
    }

    /**
     * {@inheritDoc}
     */
    public function getRatingPoints()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRatingPoints', array());

        return parent::getRatingPoints();
    }

    /**
     * {@inheritDoc}
     */
    public function setRatingsGiven($ratingsGiven)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRatingsGiven', array($ratingsGiven));

        return parent::setRatingsGiven($ratingsGiven);
    }

    /**
     * {@inheritDoc}
     */
    public function getRatingsGiven()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRatingsGiven', array());

        return parent::getRatingsGiven();
    }

    /**
     * {@inheritDoc}
     */
    public function setAuthor(\OGIS\IndexBundle\Entity\User $author = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAuthor', array($author));

        return parent::setAuthor($author);
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthor()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAuthor', array());

        return parent::getAuthor();
    }

    /**
     * {@inheritDoc}
     */
    public function setProject(\OGIS\IndexBundle\Entity\Project $project = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProject', array($project));

        return parent::setProject($project);
    }

    /**
     * {@inheritDoc}
     */
    public function getProject()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProject', array());

        return parent::getProject();
    }

    /**
     * {@inheritDoc}
     */
    public function setLayers(\OGIS\IndexBundle\Entity\Layer $layers = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLayers', array($layers));

        return parent::setLayers($layers);
    }

    /**
     * {@inheritDoc}
     */
    public function setViews($views)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setViews', array($views));

        return parent::setViews($views);
    }

    /**
     * {@inheritDoc}
     */
    public function getViews()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getViews', array());

        return parent::getViews();
    }

    /**
     * {@inheritDoc}
     */
    public function addLayer(\OGIS\IndexBundle\Entity\Layer $layers)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addLayer', array($layers));

        return parent::addLayer($layers);
    }

    /**
     * {@inheritDoc}
     */
    public function removeLayer(\OGIS\IndexBundle\Entity\Layer $layers)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeLayer', array($layers));

        return parent::removeLayer($layers);
    }

    /**
     * {@inheritDoc}
     */
    public function setProjection($projection)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProjection', array($projection));

        return parent::setProjection($projection);
    }

    /**
     * {@inheritDoc}
     */
    public function getProjection()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProjection', array());

        return parent::getProjection();
    }

    /**
     * {@inheritDoc}
     */
    public function setBoundingBoxMinX($boundingBoxMinX)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBoundingBoxMinX', array($boundingBoxMinX));

        return parent::setBoundingBoxMinX($boundingBoxMinX);
    }

    /**
     * {@inheritDoc}
     */
    public function getBoundingBoxMinX()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBoundingBoxMinX', array());

        return parent::getBoundingBoxMinX();
    }

    /**
     * {@inheritDoc}
     */
    public function setBoundingBoxMinY($boundingBoxMinY)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBoundingBoxMinY', array($boundingBoxMinY));

        return parent::setBoundingBoxMinY($boundingBoxMinY);
    }

    /**
     * {@inheritDoc}
     */
    public function getBoundingBoxMinY()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBoundingBoxMinY', array());

        return parent::getBoundingBoxMinY();
    }

    /**
     * {@inheritDoc}
     */
    public function setBoundingBoxMaxX($boundingBoxMaxX)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBoundingBoxMaxX', array($boundingBoxMaxX));

        return parent::setBoundingBoxMaxX($boundingBoxMaxX);
    }

    /**
     * {@inheritDoc}
     */
    public function getBoundingBoxMaxX()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBoundingBoxMaxX', array());

        return parent::getBoundingBoxMaxX();
    }

    /**
     * {@inheritDoc}
     */
    public function setBoundingBoxMaxY($boundingBoxMaxY)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBoundingBoxMaxY', array($boundingBoxMaxY));

        return parent::setBoundingBoxMaxY($boundingBoxMaxY);
    }

    /**
     * {@inheritDoc}
     */
    public function getBoundingBoxMaxY()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBoundingBoxMaxY', array());

        return parent::getBoundingBoxMaxY();
    }

}