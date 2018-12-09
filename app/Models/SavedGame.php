<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class SavedGame extends Model
{
   
    protected $table = 'savedgames';

    protected $fillable = [
        'id', 'username', 'category', 'level', 'progress', 'json'];

 
}
