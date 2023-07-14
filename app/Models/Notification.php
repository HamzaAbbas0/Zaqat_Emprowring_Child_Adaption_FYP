<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;

class Notification extends Model
{
    public static function getTableName()
    {
        return (new self())->getTable();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getWeekDay()
    {
        return Carbon::parse($this->created_at)->format('l');
    }

    public function getFormattedDate()
    {
        return Carbon::parse($this->created_at)->format('d M Y');
    }

    public function getFormattedTime()
    {
        return Carbon::parse($this->created_at)->format('h:m A');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
}
