<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Location;
use App\Alert;
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';

    protected $fillable = [
    'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany('App\Posts','author_id');
    }
  // user has many comments
    public function comments()
    {
        return $this->hasMany('App\Comments','from_user');
    }
    public function can_post()
    {
        $role = $this->role;
        if($role == 'author' || $role == 'admin')
        {
          return true;
      }
      return false;
  }
  public function is_admin()
  {
    $role = $this->role;
    if($role == 'admin')
    {
      return true;
    }
  return false;
}

public function locations()
{
    return $this->hasMany(Location::class);
}
public function alerts()
{
    return $this->hasMany(Alert::class);
}
}
