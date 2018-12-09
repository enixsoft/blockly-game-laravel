<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class IngameProgress extends Model
{
   
    protected $table = 'ingameprogress';

    protected $fillable = [
        'id', 'username', 'category', 'level', 'progress'];

 
}
