<?php

namespace App\Nottes\Domain\Text;

use App\Shared\Domain\Aggregate\AggregateRoot;

class Text extends AggregateRoot
{
    private \DateTimeInterface $createdAt;

    private \DateTimeInterface $updatedAt;

    private \DateTimeInterface $deletedAt;

    /**
     * @param string $id
     * @param string $name
     * @param string $content
     * @param int $format
     * @param string $folder
     * @param string|null $description
     */
    private function __construct(
        private string  $id,
        private string  $name,
        private string  $content,
        private int     $format,
        private string  $folder,
        private ?string $description = null
    )
    {
        $this->createdAt = $this->updatedAt = new \DateTime();
    }

    /**
     * @param TextId $id
     * @param string $name
     * @param string $content
     * @param TextFormat $format
     * @param string $folder
     * @param string|null $description
     * @return static
     */
    public static function create(
        TextId     $id,
        string     $name,
        string     $content,
        TextFormat $format,
        string     $folder,
        ?string    $description = null
    ): self
    {
        return new self(
            $id,
            $name,
            $content,
            (int)$format->value(),
            $folder,
            $description
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
     * @return int
     */
    public function getFormat(): int
    {
        return $this->format;
    }

    /**
     * @return string
     */
    public function getFolder(): string
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
