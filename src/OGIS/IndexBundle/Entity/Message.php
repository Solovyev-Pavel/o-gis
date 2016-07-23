<?php

namespace OGIS\IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_messages")
 */
class Message {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $subject;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sent;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $read = false;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="messagesSent", fetch="EAGER")
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="messagesReceived", fetch="EAGER")
     */
    private $addressee;

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
     * Set subject
     *
     * @param string $subject
     * @return Message
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Message
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set sent
     *
     * @param \DateTime $sent
     * @return Message
     */
    public function setSent($sent)
    {
        $this->sent = $sent;

        return $this;
    }

    /**
     * Get sent
     *
     * @return \DateTime 
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * Set read
     *
     * @param boolean $read
     * @return Message
     */
    public function setRead($read)
    {
        $this->read = $read;

        return $this;
    }

    /**
     * Get read
     *
     * @return boolean 
     */
    public function getRead()
    {
        return $this->read;
    }

    /**
     * Set sender
     *
     * @param \OGIS\IndexBundle\Entity\User $sender
     * @return Message
     */
    public function setSender(\OGIS\IndexBundle\Entity\User $sender = null)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return \OGIS\IndexBundle\Entity\User 
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set addressee
     *
     * @param \OGIS\IndexBundle\Entity\User $addressee
     * @return Message
     */
    public function setAddressee(\OGIS\IndexBundle\Entity\User $addressee = null)
    {
        $this->addressee = $addressee;

        return $this;
    }

    /**
     * Get addressee
     *
     * @return \OGIS\IndexBundle\Entity\User 
     */
    public function getAddressee()
    {
        return $this->addressee;
    }
}
