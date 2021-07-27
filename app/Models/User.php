<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'formatted_progress'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function savedGames() 
    {
        return $this->hasMany(SavedGame::class);
    }

    public function gameplay() 
    {
        return $this->hasMany(Gameplay::class);
    }

    public function bugs() 
    {
        return $this->hasMany(Bug::class);
    }

    public function progress() 
    {
        return $this->hasMany(Progress::class);
    }

    public function getFormattedProgressAttribute() 
    {
        if(empty($this->progress))
        {
            return null;
        }

        $formattedProgress = [];

        foreach ($this->progress as $categoryProgress)
        {
            $formattedProgress = array_merge($formattedProgress, $categoryProgress->toArray());       
        }

        return $formattedProgress;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'formatted_progress' => $this->formatted_progress,
            'role' => $this->role
        ];
    }
}
