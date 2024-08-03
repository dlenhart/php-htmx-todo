<?php

namespace App\Services;

use App\Constants;
use App\Repositories\TodoRepository;
use Illuminate\Database\Eloquent\Collection;

class TodoPaginationService
{
    private TodoRepository $repo;
    public int $page;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->repo = $todoRepository;
    }

    public function total(): int
    {
        return $this->repo->countTotalResources();
    }

    private function maxPages(): int
    {
        return ceil($this->total() / Constants::RESULTS_PER_PAGE);
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    private function nextPage(): int
    {
        return $this->page + 1;
    }

    public function next(): int
    {
        return $this->nextPage() > $this->maxPages() ? 0 : $this->nextPage();
    }

    private function offset(): int
    {
        return ($this->page - 1) * Constants::RESULTS_PER_PAGE;
    }

    public function todos(): Collection
    {
        return $this->repo->getPaginatedResources(
            Constants::RESULTS_PER_PAGE, $this->offset()
        );
    }
}