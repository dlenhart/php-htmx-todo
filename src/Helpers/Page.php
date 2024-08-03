<?php

namespace App\Helpers;

class Page
{
    public static function next(int $page): ?string
    {
        return $page > 0 ? "/api/todos?page=" . $page : null;
    }
}