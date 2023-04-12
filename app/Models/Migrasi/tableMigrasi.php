<?php

namespace App\Models\Migrasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tableMigrasi extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "tables";
    public $timestamps=false;

    public function restaurant()
    {
        return $this->belongsTo(restaurantMigrasi::class);
    }
    public function reservation()
    {
        return $this->hasMany(reservationMigrasi::class);
    }
}
