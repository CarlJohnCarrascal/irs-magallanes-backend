<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
class Barangay extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = [
        'name',
        'count',
        'pcount'
    ];
    protected $appends = [
        'count',
        'pcount'
    ];

    public function getCountAttribute(){
        //return Patient::all()->where('cause','=',$this->name)->where('status','!=','pending')->count();
        return DB::table('incidents as i')
        ->select('i.status as istatus')
        ->leftjoin('barangays as b', 'b.name', '=', 'i.barangay')
        ->where('i.status','!=', 'pending')
        ->where('i.barangay','=',$this->name)
        ->count();
    }
    public function getPcountAttribute(){
        //return Patient::all()->where('cause','=',$this->name)->where('status','!=','pending')->count();
        return DB::table('incidents as i')
        ->select('i.status as istatus')
        ->leftjoin('barangays as b', 'b.name', '=', 'i.barangay')
        ->where('i.status','=', 'pending')
        ->where('i.barangay','=',$this->name)
        ->count();
    }
}
