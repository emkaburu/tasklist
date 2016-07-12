<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Task extends Model  {
    
    /**
     * Mass assignables
     */
    protected $fillable = ['name', 'description'];


    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
