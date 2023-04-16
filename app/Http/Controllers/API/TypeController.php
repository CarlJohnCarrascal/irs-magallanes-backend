<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Type;
use Illuminate\Http\Request;
use Validator;

class TypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendResponse(Type::all(), 'Incident Type List.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:types',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $types = Type::create($input);
        return $this->sendResponse($types, 'Incident Type Store successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $types)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $types->update($input);

        return $this->sendResponse($types, 'Incident Type Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $types)
    {
        $role = auth('api')->user()->role;
        if($role != 'admin') return $this->sendError('Unauthorized.', 'Unauthorized', 401);

        $types->delete();
        return $this->sendResponse($types, 'Incident Type deleted successfully!.');
    }

    public function deleteitem(Type $type)
    {
        $role = auth('api')->user()->role;
        if($role != 'admin') return $this->sendError('Unauthorized.', 'Unauthorized', 401);

        $type->delete();
        return $this->sendResponse($type, 'Incident Type deleted successfully!.');
    }
}
