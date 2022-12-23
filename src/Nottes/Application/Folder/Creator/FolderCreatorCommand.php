<?php

namespace App\Nottes\Application\Folder\Creator;

use App\Shared\Application\ApplicationServiceRequest;

class FolderCreatorCommand implements ApplicationServiceRequest
{
    private string $name;
    private ?string $parent;
    private ?string $description;

    /**
     * @param string $name
     * @param string|null $parent
     * @param string|null $description
     */
    public function __construct(
        string $name,
        ?string $parent = null,
        ?string $description = null
    )
    {
        $this->name = $name;
        $this->parent = $parent;
        $this->description = $description;
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
    public function getParent(): ?string
    {
        return $this->parent;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
