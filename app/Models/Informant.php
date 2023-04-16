<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informant extends Model
{
    use HasFactory;

    protected $fillable = [
        'incidentid',
        'name',
        'address',
        'date_of',
        'time_of',
        'phone',
    ];
}
