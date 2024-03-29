<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{   
    protected $table = 'bugs';

    protected $fillable = [
        'user_id', 
        'category', 
        'level', 
        'report'
    ]; 
}
