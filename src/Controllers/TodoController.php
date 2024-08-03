<?php
namespace App\Controllers;

use App\Constants;
use App\Controllers\Controller;
use App\Core\Response;
use App\Core\Request;
use App\Helpers\Page;
use App\Repositories\TodoRepository;
use App\Services\TodoPaginationService;

class TodoController extends Controller
{
    private TodoRepository $repo;
    private TodoPaginationService $paginate;

    public function __construct()
    {
        parent::__construct();
        $this->repo = new TodoRepository();
        $this->paginate = new TodoPaginationService($this->repo);
    }

    public function list()
    {
        if (isset(Request::params()->id)) {
            $id = Request::params()->id;
            $todo = $this->repo->getResourceById($id);

            if ($todo == null) {
                return Response::json(
                    [
                    'message' => Constants::TODO_NOT_FOUND
                    ], 404
                );
            }

            return Response::json($todo);
        }

        $this->paginate->setPage(isset(Request::params()->page) ? Request::params()->page : 1);

        return Response::json(
            [
            'count' => $this->paginate->total(),
            'next' => Page::next($this->paginate->next()),
            'results' => $this->paginate->todos()
            ]
        );
    }

    public function store()
    {
        $body = Request::body();

        if ($this->repo->storeResource($body)) {
            return Response::json(['message' => Constants::TODO_CREATED], 201);
        }

        return Response::json(['message' => Constants::TODO_FAIL], 500);
    }

    public function update()
    {
        $body = Request::body();

        if ($this->repo->updateResource($body)) {
            return Response::json(['message' => Constants::TODO_UPDATED], 202);
        }

        return Response::json(['message' => Constants::TODO_NOT_FOUND], 404);
    }

    public function delete()
    {
        if (isset(Request::params()->id)) {
            if ($this->repo->deleteResource(Request::params()->id)) {
                return Response::json(['message' => Constants::TODO_DELETED], 202);
            }
        }

        return Response::json(['message' => Constants::TODO_NOT_FOUND], 404);
    }
}