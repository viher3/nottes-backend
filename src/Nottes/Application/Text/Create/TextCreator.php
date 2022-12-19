<?php

namespace App\Nottes\Application\Text\Create;

use App\Nottes\Domain\Text\TextRepository;

final class TextCreator
{
    private TextRepository $textRepository;

    /**
     * @param TextRepository $textRepository
     */
    public function __construct(TextRepository $textRepository)
    {
        $this->textRepository = $textRepository;
    }

    /**
     * @param TextCreatorRequest $textCreatorRequest
     * @return void
     */
    public function execute(TextCreatorRequest $textCreatorRequest) : TextCreatorResponse
    {

    }
}
