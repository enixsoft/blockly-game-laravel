<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Progress
 */
class Progress extends Model
{   
    protected $table = 'progress';

    protected $fillable = [
        'user_id', 
        'category', 
        'level', 
        'progress'
    ]; 

    /**
     * @return array
     */
    public function toArray()
    {
        $progress = [];
        for ($i = 1; $i <= $this->level; $i++)
        {
            if ($i == $this->level) 
            {
                $progress[] = $this->progress;
            }                 
            else 
            {
                $progress[] = 100;
            }                      
        }
    
        return $progress;
    }
}
