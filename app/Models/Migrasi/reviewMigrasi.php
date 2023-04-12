<?php

namespace App\Models\Migrasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reviewMigrasi extends Model
{
    use HasFactory;
    protected $table = "reviews";
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(userMigrasi::class);
    }
    public function restaurant()
    {
        return $this->belongsTo(restaurantMigrasi::class);
    }
}
