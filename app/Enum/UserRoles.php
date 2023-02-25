<?php

namespace App\Enum;


use Exception;
use Illuminate\Contracts\Translation\Translator;

enum UserRoles: string
{
    case ROOT = "ROOT";
    case ADMINISTRATOR = "ADMINISTRATOR";

    public function description(): string
    {
        return self::getDescription($this);
    }

    /**
     * @param UserRoles $value
     * @return array|string|Translator
     * @throws Exception
     */
    public static function getDescription(self $value): array|string|Translator
    {
        return match ($value) {
            self::ADMINISTRATOR => __('administrator'),
            default => throw new Exception('Unexpected match value'),
        };
    }
}
