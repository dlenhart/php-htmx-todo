<?php
namespace App\Database\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
class Todo extends Eloquent
{
    protected $fillable = ['todo','category','description'];
}