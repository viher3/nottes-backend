<?php

namespace App\Nottes\Application\Text\Create;

final class TextCreatorRequest
{
    /**
     * @param string $name
     * @param string $content
     * @param int $format
     * @param string|null $folder
     * @param string|null $description
     */
    public function __construct(
        private readonly string  $name,
        private readonly string  $content,
        private readonly int     $format,
        private readonly ?string $folder = null,
        private readonly ?string $description = null
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
