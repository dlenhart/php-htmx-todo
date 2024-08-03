<?php

namespace App\Core;

class Response
{
    public static function json($data = [], $status = 200)
    {
        header_remove();
        header("Content-Type: application/json");

        $json = json_encode($data);

        if ($json === false) {
            $json = json_encode(["jsonError" => json_last_error_msg()]);

            http_response_code(500);
        }

        http_response_code($status);
        echo $json;

        exit();
    }

    public static function notFound($message, $status = 404)
    {
        http_response_code($status);
        return self::view('notfound', ['message' => $message]);
    }

    public static function view($name, $data = [])
    {
        extract($data);
        return include __DIR__ . "/../Views/{$name}.view.php";
    }
}