<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends BaseController
{
    public function index(Request $request) {
        $res = [];
        $id = auth('api')->user()->id;
        $role = auth('api')->user()->role;

        $in = $request->all();
        if ($in['unread'] == 'true'){
            $res = Notification::all()->where('isseed','=','false');
            $res = Notification::where('for_user','=', $role)
            ->orWhere('for_user','=', $id)
            ->orWhere('for_user','=', 'all')
            ->where('isseen','=','false')
            ->orderBy('created_at', 'desc')
            ->get();
        }else{
            $res = Notification::where('for_user','=', $role)
            ->orWhere('for_user','=', 'all')
            ->orWhere('for_user','=', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        }
        return $this->sendResponse($res, 'Notification List.');
    }

    public function getnew(){
        $id = auth('api')->user()->id;
        $role = auth('api')->user()->role;

        $res = Notification::offset(0)
        ->limit(5)
        ->where('for_user','=', $role)
            ->orWhere('for_user','=', 'all')
            ->orWhere('for_user','=', $id)
            ->orderBy('created_at', 'desc')
        ->get();
        return $this->sendResponse($res, 'Notification List.');
    }

    public function getnot(){
        $res = Notification::all()->where('isseen','=',false)->count();

        return $this->sendResponse($res, 'Notification List.');
    }

    public function markseen(Notification $notification){
        $notification->isseen = true;
        $notification->update();
        return $this->sendResponse('', 'Marked Seen');
    }
    
}
