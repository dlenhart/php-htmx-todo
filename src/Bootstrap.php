<?php
require_once __DIR__.'/../vendor/autoload.php';
require __DIR__.'/database/Bootstrap.php';

use App\Core\App;

$app = App::initialize();

// Routes
$app->get('', 'AppController@index');
//$app->get('migrate', 'MigrationController@migrate');
$app->get('api/todos', 'TodoController@list');
$app->post('api/todos', 'TodoController@store');
$app->put('api/todos', 'TodoController@update');
$app->delete('api/todos', 'TodoController@delete');

// Run!
$app->run();
