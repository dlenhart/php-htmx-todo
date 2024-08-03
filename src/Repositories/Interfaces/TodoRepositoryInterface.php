<?php

namespace App\Repositories\Interfaces;

use App\Database\Models\Todo;
use Illuminate\Database\Eloquent\Collection;

interface TodoRepositoryInterface
{
    public function countTotalResources(): int|null;

    public function getPaginatedResources($limit, $offset): Collection;

    public function getResourceById(int $id): Todo|null;

    public function storeResource(array $todo): Todo;

    public function updateResource(array $todo): Todo|null;

    public function deleteResource(int $id): bool;
}