<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Gameplay extends Model
{
   
    protected $table = 'gameplay';

    protected $fillable = [
        'id', 'username', 'category', 'level', 'level_start', 'task', 'task_start', 'task_end', 'task_elapsed_time', 'code', 'result'];

 
}

