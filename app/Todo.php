<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $table = 'todo';
	protected $fillable = ['cim','description','file','user_id'];
}
