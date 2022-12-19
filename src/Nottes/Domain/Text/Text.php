<?php

namespace App\Nottes\Domain\Text;

use App\Nottes\Domain\Folder\Folder;
use App\Shared\Domain\Aggregate\AggregateRoot;

final class Text extends AggregateRoot
{
    private string $id;

    private string $name;

    private ?string $description;

    private string $content;

    private string $format;

    private ?Folder $folder;

    private \DateTimeInterface $createdAt;

    private \DateTimeInterface $updatedAt;

    private \DateTimeInterface $deletedAt;

    /**
     * @param TextId $id
     * @param string $name
     * @param string $content
     * @param string $format
     * @param string|null $description
     * @param Folder|null $folder
     */
    private function __construct(
        TextId  $id,
        string  $name,
        string  $content,
        string  $format,
        ?string $description = null,
        ?Folder $folder = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->content = $content;
        $this->format = $format;
        $this->folder = $folder;
        $this->createdAt = $this->updatedAt = new \DateTime();
    }

    /**
     * @param TextId $id
     * @param string $name
     * @param string $content
     * @param string $format
     * @param string|null $description
     * @param Folder|null $folder
     * @return static
     */
    public static function create(
        TextId  $id,
        string  $name,
        string  $content,
        string  $format,
        ?string $description = null,
        ?Folder $folder = null
    ): self
    {
        return new self(
            $id,
            $name,
            $content,
            $format,
            $description,
            $folder
        );
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
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @return Folder|null
     */
    public function getFolder(): ?Folder
    {
        return $this->folder;
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
