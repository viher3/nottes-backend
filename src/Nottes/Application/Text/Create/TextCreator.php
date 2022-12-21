<?php

namespace App\Nottes\Application\Text\Create;

use App\Nottes\Domain\Folder\FolderId;
use App\Nottes\Domain\Folder\FolderRepository;
use App\Nottes\Domain\Text\Text;
use App\Nottes\Domain\Text\TextFormat;
use App\Nottes\Domain\Text\TextId;
use App\Nottes\Domain\Text\TextRepository;

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
     * @param TextCreatorRequest $request
     * @return TextCreatorResponse
     * @throws \Exception
     */
    public function execute(TextCreatorRequest $request) : TextCreatorResponse
    {
        $folderId = $request->getFolder() ? new FolderId($request->getFolder()) : null;
        $folder = $folderId ? $this->folderRepository->find($folderId) : null;

        $text = Text::create(
            TextId::random(),
            $request->getName(),
            $request->getContent(),
            new TextFormat($request->getFormat()),
            $folder,
            $request->getDescription()
        );

        $this->textRepository->save($text);

        return new TextCreatorResponse();
    }
}
