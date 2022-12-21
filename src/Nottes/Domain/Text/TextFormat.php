<?php

namespace App\Nottes\Domain\Text;

use App\Shared\Domain\ValueObject\IntValueObject;

class TextFormat extends IntValueObject
{
    const TEXT_FORMAT_ID = 1;
    const TEXT_FORMAT_LABEL = 'Text';

    const HTML_FORMAT_ID = 2;
    const HTML_FORMAT_LABEL = 'HTML';

    const MARKDOWN_FORMAT_ID = 3;
    const MARKDOWN_FORMAT_LABEL = 'Markdown';

    const FORMATS_LIST = [
        self::TEXT_FORMAT_LABEL => self::TEXT_FORMAT_ID,
        self::HTML_FORMAT_LABEL => self::HTML_FORMAT_ID,
        self::MARKDOWN_FORMAT_LABEL => self::MARKDOWN_FORMAT_ID
    ];

    /**
     * @throws \Exception
     */
    public function __construct(int $value)
    {
        if(!in_array($value, self::FORMATS_LIST)){
            throw new \Exception("TextFormat '$value' value not found.");
        }

        parent::__construct($value);
    }
}
