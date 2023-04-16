<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\IncidentCause;
use App\Models\Type;
use Illuminate\Http\Request;
use Validator;

class IncidentCauseController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendResponse(IncidentCause::all(), 'Cause List.');
    }
    public function indexbytype(Type $type)
    {
        return $this->sendResponse(IncidentCause::all()->where('type_id', '==', $type->id), 'Cause List.');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'type_id' => 'required',
            'name' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();

        $count = IncidentCause::all()->where('name','=', $input['name'])->where('type_id','=',$input['type_id'])->count();
        if ($count > 0) {
            $err = ['name' => ['The name is already been taken.']];
            return $this->sendError('Validation Error.', $err);
        }

        $cause = IncidentCause::create($input);
        return $this->sendResponse($cause, 'Cause Store successfully.');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IncidentCause $incidentCause)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $incidentCause->update($input);

        return $this->sendResponse($incidentCause, 'Incident Cause Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncidentCause $incidentCause)
    {
        $role = auth('api')->user()->role;
        if($role != 'admin') return $this->sendError('Unauthorized.', 'Unauthorized', 401);

        $incidentCause->delete();
        return $this->sendResponse('', 'Incident Cause deleted successfully!.');
    }
}
