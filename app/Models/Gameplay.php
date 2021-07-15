<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gameplay extends Model
{   
    protected $table = 'gameplay';

    protected $fillable = [
        'id', 
        'user_id', 
        'category', 
        'level', 
        'level_start', 
        'task', 
        'task_start', 
        'task_end', 
        'task_elapsed_time', 
        'rating', 
        'code', 
        'result'
    ]; 
}
