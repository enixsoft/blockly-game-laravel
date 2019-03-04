<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Bug extends Model
{
   
    protected $table = 'bugs';

    protected $fillable = [
        'id', 'username', 'category', 'level', 'report' ];

 
}
