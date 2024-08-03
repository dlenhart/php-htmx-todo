<?php
namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as Capsule;


class MigrationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function migrate()
    {
        //This will bark at you if already exists
        Capsule::schema()->create(
            'todos', function ($table) {
                $table->increments('id');
                $table->string('todo');
                $table->string('description');
                $table->string('category');
                $table->timestamps();
            }
        );
    }
}