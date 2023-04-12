<?php

namespace App\Models\Migrasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class userMigrasi extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "users";

    public function role()
    {
        return $this->hasOne(roleMigrasi::class,"id","role_id");
    }
    public function posts()
    {
        return $this->hasMany(postMigrasi::class,"user_id","id");
    }
    public function gender()
    {
        return $this->hasOne(genderMigrasi::class);
    }
    public function review()
    {
        return $this->hasMany(reviewMigrasi::class);
    }
    public function reservation()
    {
        return $this->hasMany(reservationMigrasi::class);
    }
    public function restaurant()
    {
        return $this->hasOne(restaurantMigrasi::class);
    }
    public function favourite()
    {
        return $this->hasMany(favouriteMigrasi::class,'user_id','id');
    }
}
