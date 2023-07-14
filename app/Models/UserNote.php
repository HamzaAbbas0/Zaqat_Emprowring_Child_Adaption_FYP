<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;

class UserNote extends Model
{
    public static function getTableName()
    {
        return (new self())->getTable();
    }

    public function user(){
        return $this->belongsTo(User::class, 'by_user_id');
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }
}
