<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'userid',
        'manageby',
        'report_type',
        'type',
        'causes',
        'datetime',
        'phone',
        'barangay',
        'purok',
        'latitude',
        'longitude',
        'spicific_location',
        'description',
        'person_involves',
        'is_police_needed',
        'is_ambulance_needed',
        'seened_at',
        'accepted_at',
        'severity',
        'status',
        'report_pat',
        'report_inf',
        'report_res',
        'fulllocation',
    ];

    protected $appends = [
        'report_pat',
        'report_inf',
        'report_res',
        'fulllocation',
    ];

    public function getReportPatAttribute() {
        return Patient::all()->where('incidentid', '=', $this->id);
    }
    public function getReportInfAttribute() {
        return Informant::all()->where('incidentid', '=', $this->id)->first();
    }
    public function getReportResAttribute() {
        return Responder::all()->where('incidentid', '=', $this->id)->first();
    }
    public function getFulllocationAttribute() {
        return $this->purok . ' - ' . $this->barangay . ' - ' . $this->spicific_location;
    }
}
