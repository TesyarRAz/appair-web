<?php

namespace App\Models;

use App\Casts\PublicFileClientCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'image' => PublicFileClientCast::class,
    ];
}
