<?php

namespace App\Models\Migrasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class genderMigrasi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "genders";

    public function user()
    {
        return $this->belongsTo(userMigrasi::class);
    }
}
