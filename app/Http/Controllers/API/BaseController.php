<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * success response method
     * 
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }
    
    /**
     * error response method
     * 
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    public function addToNotification($for, $type, $message, $itemId, $isnewUser = false,$id = ''){
        $newNotif['for_user'] = $for;
        if(!$isnewUser){
            $id = auth('api')->user()->id;
        }
        $newNotif['user_id'] = $id;
        $newNotif['type'] = $type;
        $newNotif['message'] = $message;
        $newNotif['notif_id'] = $itemId;
        Notification::create($newNotif);
    }
}
