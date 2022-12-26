<?php

namespace App\Nottes\Application\Text\Create;

use App\Nottes\Domain\Folder\FolderNotFound;
use App\Nottes\Domain\Text\Text;
use App\Nottes\Domain\Text\TextId;
use App\Nottes\Domain\Folder\FolderId;
use App\Nottes\Domain\Text\TextFormat;
use App\Nottes\Domain\Text\TextRepository;
use App\Nottes\Domain\Folder\FolderRepository;

final class TextCreator
{
    /**
     * @param TextRepository $textRepository
     * @param FolderRepository $folderRepository
     */
    public function __construct(
        private TextRepository $textRepository,
        private FolderRepository $folderRepository
    )
    {
    }

    /**
     * @param TextCreatorCommand $command
     * @return TextCreatorResponse
     * @throws \Exception
     */
    public function execute(TextCreatorCommand $command) : TextCreatorResponse
    {
        $folderId = $command->getFolder() ? new FolderId($command->getFolder()) : null;
        $folder = $folderId ? $this->folderRepository->find($folderId) : null;

        if(!$folder){
            throw new FolderNotFound($folderId, true);
        }

        $text = Text::create(
            TextId::random(),
            $command->getName(),
            $command->getContent(),
            new TextFormat($command->getFormat()),
            $folderId,
            $command->getDescription()
        );

        $this->textRepository->save($text);

        return new TextCreatorResponse();
    }
}
