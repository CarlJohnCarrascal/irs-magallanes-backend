<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends BaseController
{
    public function index(Request $request) {
        $res = [];
        $in = $request->all();
        if ($in['unread'] == true){
            $res = Notification::all()->where('isseed','=','false');
        }else{
            $res = Notification::all();
        }
        return $this->sendResponse($res, 'Notification List.');
    }

    public function get20(Request $request){
        $in = $request->all();
        $res = Notification::all()
        ->limit(20)
        ->get();
        return $this->sendResponse($res, 'Notification List.');
    }
}
