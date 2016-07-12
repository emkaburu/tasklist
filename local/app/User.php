<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Task;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get this user's tasks
     */
    public function tasks() {
        return $this->hasMany(Task::class, 'user_id');
    }

    /**
     * Get user role ... regular or admin
     */
    public function userRole()
      {
        $role = $this->role;
        return $role;
        
      }

      /**
       * is user admin?
       */
      public function isAdmin()      {
        $role = $this->role;
        
        if($role == 'admin')
        {
          return true;
        }
        return false;
      }

      /**
       * get the names or email address of the user with the @param $id
       */
      public static function getName($id){
        $user = User::where('id', $id)->first();

        // print_r($user);
        $name = "";
        if($user->firstname != "")
            $name .= $user->firstname. " ";

        if($user->lastname != "")
            $name .= $user->lastname;

        if($user->firstname == "" && $user->lastname == "")
            $name = $user->email;

        return $name;
      }
}
