<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use Notifiable;

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'name',
    'email',
    'password',
    'nome_attivita',
    'via',
    'n_civico',
    'citta',
    'cap',
    'p_iva',
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
  * The attributes that should be cast to native types.
  *
  * @var array
  */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];


  //One to Many   Restaurant to Dishes
  public function dishes()
  {
    return $this -> hasMany(Dish::class);
  }


  //One to Many   Restaurant to Orders
  public function orders()
  {
    return $this -> hasMany(Order::class);
  }


  //Many to Many  Restaurants to Types
  public function types() {

    return $this -> belongsToMany(Type::class);
  }
}
