<?php

namespace App\Repositories;

use App\Database\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;


class TodoRepository implements TodoRepositoryInterface
{

    public function getResourceById(int $id): Todo|null
    {
        return Todo::find($id);
    }

    public function countTotalResources(): int
    {
        return Todo::orderBy('created_at', 'desc')->get()->count();
    }

    public function getPaginatedResources($limit, $offset): Collection
    {
        return Todo::orderBy('created_at', 'desc')->limit($limit)->offset($offset)->get();
    }

    public function storeResource(array $todo): Todo
    {
        try {
            $store = new Todo();
            $store->todo = $todo['todo'];
            $store->category = $todo['category'];
            $store->description = $todo['description'];
            $store->save();
        } catch (\Throwable $e) {
            die($e);
        }

        return $store;
    }

    public function updateResource(array $todo): Todo|null
    {
        $todo = $this->getResourceById($todo['id']);

        if (!$todo) {
            return null;
        }

        try {
            $todo->todo = $todo['todo'];
            $todo->category = $todo['category'];
            $todo->description = $todo['description'];
            $todo->save();
        } catch (\Throwable $e) {
            die($e);
        }

        return $todo;
    }

    public function deleteResource(int $id): bool
    {
        try {
            $todo = Todo::destroy($id);
        } catch (\Throwable $e) {
            die($e);
        }

        return $todo;
    }
}