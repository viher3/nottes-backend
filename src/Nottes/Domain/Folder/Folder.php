<?php

namespace App\Nottes\Domain\Folder;
use App\Shared\Domain\Aggregate\AggregateRoot;

class Folder extends AggregateRoot
{
    private string $id;

    private string $name;

    private ?string $description;

    private \DateTimeInterface $createdAt;

    private \DateTimeInterface $updatedAt;

    private \DateTimeInterface $deletedAt;

    /**
     * @param string $id
     * @param string $name
     * @param string|null $description
     */
    public function __construct(string $id, string $name, ?string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $this->updatedAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDeletedAt(): \DateTimeInterface
    {
        return $this->deletedAt;
    }
}
