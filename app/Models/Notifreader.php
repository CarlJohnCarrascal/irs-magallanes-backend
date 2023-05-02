<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifreader extends Model
{
    use HasFactory;

    protected $fillable = [
        'notif_id',
        'user_id',
        'isseen',
    ];
}
