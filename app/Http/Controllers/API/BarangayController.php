<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Validator;

class BarangayController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendResponse(Barangay::all(), 'Barangay List.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:barangays',
        ]);

        $role = auth('api')->user()->role;
        if($role != 'admin') return $this->sendError('Unauthorized.', 'Unauthorized', 401);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $barangay = Barangay::create($input);
        return $this->sendResponse($barangay, 'Barangay Store successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barangay $barangay)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        $role = auth('api')->user()->role;
        if($role != 'admin') return $this->sendError('Unauthorized.', 'Unauthorized', 401);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $barangay->update($input);

        return $this->sendResponse($barangay, 'Barangay Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barangay $barangay)
    {
        
        $role = auth('api')->user()->role;
        if($role != 'admin') return $this->sendError('Unauthorized.', 'Unauthorized', 401);

        $barangay->delete();
        return $this->sendResponse('', 'Barangay deleted successfully!.');
    }
}
