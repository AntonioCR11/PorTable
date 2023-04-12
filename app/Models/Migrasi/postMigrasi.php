<?php

namespace App\Models\Migrasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class postMigrasi extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "posts";
    protected $fillable = [
        'title',
        'caption',
        'user_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(userMigrasi::class,"id","user_id");
    }
}
