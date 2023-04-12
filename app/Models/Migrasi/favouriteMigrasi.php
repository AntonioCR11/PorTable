<?php

namespace App\Models\Migrasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favouriteMigrasi extends Model
{
    use HasFactory;

    protected $table = "favourites";
    public $timestamps = false;

    public function restaurant()
    {
        return $this->belongsTo(restaurantMigrasi::class,'restaurant_id','id');
    }
    public function user()
    {
        return $this->belongsTo(userMigrasi::class,'user_id','id');
    }

}
