<?php

namespace App\Core;

class Request
{
    public static function params(): \stdClass
    {
        $object = new \stdClass();

        foreach ($_GET as $key => $value) {
            $object->$key = htmlspecialchars(strip_tags($value));
        }

        return $object;
    }

    public static function body(): array
    {
        $post = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() == JSON_ERROR_NONE) {
            return $post;
        }

        return [];
    }
}