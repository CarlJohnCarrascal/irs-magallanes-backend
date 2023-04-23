<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class IncidentCause extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = [
        'type_id',
        'name',
        'description',
        'count',
    ];

    protected $appends = [
        'count'
    ];

    public function getCountAttribute(){
        return Patient::all()->where('cause','=',$this->name)->count();
    }
}
