<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\IncidentStatus;
use Illuminate\Http\Request;

class IncidentStatusController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendResponse(IncidentStatus::all(), 'Incident Status List.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $incidentStatus = IncidentStatus::create($input);
        return $this->sendResponse($incidentStatus, 'Incident Status Store successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IncidentStatus $incidentStatus)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $incidentStatus->update($input);

        return $this->sendResponse($incidentStatus, 'Incident Status Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncidentStatus $incidentStatus)
    {
        $incidentStatus->delete();
        return $this->sendResponse('', 'Incident Status deleted successfully!.');
    }
}
