<?php

namespace OGIS\IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_user_project")
 */
class ProjectParticipation
{

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="projects")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
	 */
	protected $user;

	/**
	 * @ORM\ManyToOne(targetEntity="Project", inversedBy="participants")
	 * @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=false)
	 */
	protected $project;

	/**
	 * @ORM\Column(type="string", length=32, nullable=false)
	 */
	protected $rank = "Project member";


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
     * Set rank
     *
     * @param string $rank
     * @return ProjectParticipation
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return string 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set user
     *
     * @param \OGIS\IndexBundle\Entity\User $user
     * @return ProjectParticipation
     */
    public function setUser(\OGIS\IndexBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \OGIS\IndexBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set project
     *
     * @param \OGIS\IndexBundle\Entity\Project $project
     * @return ProjectParticipation
     */
    public function setProject(\OGIS\IndexBundle\Entity\Project $project)
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
}
