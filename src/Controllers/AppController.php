<?php
namespace App\Controllers;

use App\Controllers\Controller;
use App\Core\Response;
use App\Core\Request;
use App\Helpers\Page;
use App\Repositories\TodoRepository;
use App\Services\TodoPaginationService;


class AppController extends Controller
{
    private TodoRepository $repo;
    private TodoPaginationService $paginate;

    public function __construct()
    {
        parent::__construct();
        $this->repo = new TodoRepository();
        $this->paginate = new TodoPaginationService($this->repo);
    }

    public function index()
    {
        $this->paginate->setPage(isset(Request::params()->page) ? Request::params()->page : 1);

        $data = [
            'count' => $this->paginate->total(),
            'next' => Page::next($this->paginate->next()),
            'results' => $this->paginate->todos()
        ];

        return Response::view("home", $data);
    }
}