<?php

namespace App\Models\Migrasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roleMigrasi extends Model
{
    use HasFactory;
    protected $table = "roles";
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(userMigrasi::class,"role_id","id");
    }
}
