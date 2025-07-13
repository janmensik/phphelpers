<?php

namespace JanMensik\PHPHelpers;

class Helpers
{
    /**
     * Example helper: Convert string to snake_case
     */
    public static function toSnakeCase(string $input): string
    {
        return strtolower(preg_replace('/[A-Z]/', '_$0', lcfirst($input)));
    }
}
