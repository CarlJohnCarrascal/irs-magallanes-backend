<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Severity;
use Illuminate\Http\Request;

class SeverityController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendResponse(Severity::all(), 'Severity List.');
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
        $severity = Severity::create($input);
        return $this->sendResponse($severity, 'Incident Severity Store successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Severity $severity)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $severity->update($input);

        return $this->sendResponse($severity, 'Incident Severity Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Severity $severity)
    {
        $severity->delete();
        return $this->sendResponse('', 'Incident Severity deleted successfully!.');
    }
}
