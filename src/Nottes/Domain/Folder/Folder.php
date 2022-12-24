<?php

namespace App\Nottes\Domain\Folder;

use App\Shared\Domain\Aggregate\AggregateRoot;

class Folder extends AggregateRoot
{
    private string $id;

    private string $name;

    private ?string $description;

    private ?Folder $parent;

    private \DateTimeInterface $createdAt;

    private \DateTimeInterface $updatedAt;

    private \DateTimeInterface $deletedAt;

    /**
     * @param string $id
     * @param string $name
     * @param Folder|null $parent
     * @param string|null $description
     */
    private function __construct(string $id, string $name, ?Folder $parent, ?string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->parent = $parent;
        $this->description = $description;
        $this->createdAt = $this->updatedAt = new \DateTime();
    }

    /**
     * @param FolderId $id
     * @param string $name
     * @param Folder|null $parent
     * @param string|null $description
     * @return static
     */
    public static function create(
        FolderId $id,
        string $name,
        ?Folder $parent,
        ?string $description
    ) : self
    {
        return new self(
            $id->value(),
            $name,
            $parent,
            $description
        );
    }

    /**
     * @return FolderId
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

    /**
     * @return Folder|null
     */
    public function getParent(): ?Folder
    {
        return $this->parent;
    }
}
