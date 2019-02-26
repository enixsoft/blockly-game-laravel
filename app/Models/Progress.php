<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Progress extends Model
{
   
    protected $table = 'progress';

    protected $fillable = [
        'id', 'username', 'category', 'level', 'progress'];

 
}
