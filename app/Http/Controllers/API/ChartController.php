<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\IncidentCause;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends BaseController
{
    public function accidenttypechart()
    {
        $type = Type::all(['name as type','id']);
        for ($i=0; $i < count($type); $i++) { 
            $type[$i]['causes'] = IncidentCause::all(['name','type_id'])->where('type_id','==',$type[$i]->id);
            $type[$i]['id'] = $type[$i]->id;
        }
        return $this->sendResponse($type, 'Incident Type List.');
    }
}
