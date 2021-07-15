<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedGame extends Model
{   
    protected $table = 'savedgames';

    protected $fillable = [
        'id', 
        'user_id', 
        'category', 
        'level', 
        'progress', 
        'json'
    ];
}
