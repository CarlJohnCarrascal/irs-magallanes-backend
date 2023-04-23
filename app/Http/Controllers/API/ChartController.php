<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Barangay;
use App\Models\IncidentCause;
use App\Models\Type;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends BaseController
{

    public function incidentchart()
    {
        $from_date = date('Y-m-d');
        $today = Incident::whereDate('datetime', '=', $from_date)->where('status', '!=', 'pending')->count();

        $month_start = date('Y-m-01');
        $month_end = date('Y-m-t');
        $month = Incident::whereBetween('datetime', [$month_start, $month_end])->where('status', '!=', 'pending')->count();

        $yeardate = date('Y');
        $year = Incident::whereYear('datetime', $yeardate)->where('status', '!=', 'pending')->count();

        $pending = Incident::all()->where('status','=','pending')->count();
        $res['today'] = $today;
        $res['month'] = $month;
        $res['year'] = $year;
        $res['pending'] = $pending;
        return $this->sendResponse($res, 'Incident Report Data.');
    }

    public function barangaychart(){
        $brgy = Barangay::all('name');
        $res = [];
        $br = [];
        $c = [];
        $pc = [];
        foreach ($brgy as $b) {
            array_push($br, $b->name);
            array_push($c, $b->count);
            array_push($pc, $b->pcount);
        }
        $res['brgy'] = $br;
        $res['count'] = $c;
        $res['pcount'] = $pc;
        return $this->sendResponse($res, 'Incident Report Data.');
    }

    public function accidenttypechart()
    {
        $types = Type::all(['name as type', 'id']);
        $res = [];
        foreach ($types as $t) {
            $tt = [];
            $tt['type'] = $t->type;
            $c = IncidentCause::all(['name', 'type_id','status'])
            ->where('type_id', '==', $t->id);
            $cl = [];
            $dl = [];
            $dpl = [];
            foreach ($c as $cc) {
                array_push($cl, $cc->name);
                array_push($dl, $cc->count);
                array_push($dpl, $cc->pcount);
            }
            $tt['causes'] = $cl;
            $tt['data'] = $dl;
            $tt['pdata'] = $dpl;
            array_push($res, $tt);
        }

        return $this->sendResponse($res, 'Accident Type Chart Data.');
    }
}
