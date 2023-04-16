<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'incidentid',
        'name',
        'address',
        'age',
        'gender',
        'status',
        'cause',
        'incident_date',
        'incident_type',
    ];

    protected $appends = [
        'incident_date',
        'incident_type',
    ];

    public function getIncidentDateAttribute(){
        return DB::table('incidents')->where('id', $this->incidentid)->value('datetime');
    }
    public function getIncidentTypeAttribute(){
        return DB::table('incidents')->where('id', $this->incidentid)->value('type');   
    }
}
