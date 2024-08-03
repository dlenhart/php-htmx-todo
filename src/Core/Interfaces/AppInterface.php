<?php

namespace App\Core\Interfaces;

interface AppInterface
{
    public function get(string $uri, string $controller): void;

    public function post(string $uri, string $controller): void;

    public function run(): mixed;
}