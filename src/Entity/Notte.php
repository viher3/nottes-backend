<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notte
 *
 * @ORM\Table(name="nottes")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\NotteRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Notte
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=5)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tags", type="string", length=255, nullable=true)
     */
    private $tags;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_encrypted", type="boolean")
     */
    private $isEncrypted;
    private $isDecrypted = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var \App\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="creator_user_id", referencedColumnName="id")
     * })
     */
    private $creatorUser;

    public function __construct()
    {
        $this->type = "doc";
        $this->isEncrypted = false;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param string|null $tags
     *
     * @return self
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEncrypted()
    {
        return $this->isEncrypted;
    }

    /**
     * @param bool $isEncrypted
     *
     * @return self
     */
    public function setIsEncrypted($isEncrypted)
    {
        $this->isEncrypted = $isEncrypted;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return \App\Entity\User
     */
    public function getCreatorUser()
    {
        return $this->creatorUser;
    }

    /**
     * @param \App\Entity\User $creatorUser
     *
     * @return self
     */
    public function setCreatorUser(\App\Entity\User $creatorUser)
    {
        $this->creatorUser = $creatorUser;

        return $this;
    }

    
    public function setCreatedValue()
    {
        $currDatetime = new \DateTime();
        $this->createdAt = $currDatetime;
        $this->updatedAt = $currDatetime;
    }

    public function setUpdatedValue()
    {
        $this->updatedAt = new \DateTime();
    }

    public function isDecrypted($isDecrypted)
    {
        $this->isDecrypted = $isDecrypted;
    }
    
}
