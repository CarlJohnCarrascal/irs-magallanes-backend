<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notifreader;
class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'for_user',
        'message',
        'notif_id',
        'isseen',
        'seen_date',
        'isalreadyseen',
    ];

    protected $appends = [
        'isalreadyseen',
    ];

    public function getIsAlreadySeenAttribute() {
        $id = auth('api')->user()->id;

        $res = Notifreader::all()
        ->where('notif_id','=',$this->id)
        ->where('user_id','=',$id)
        ->count();
        if ($res > 0) {
            return true;
        }else{
            return false;
        }
    }
}
