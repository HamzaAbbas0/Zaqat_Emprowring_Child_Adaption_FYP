<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Children;

class Family extends Model
{
    public static function getTableName()
    {
        return (new self())->getTable();
    }

    public function children() {
        return $this->hasMany(Children::class);
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function getCityName(){
        $city = getCityById($this->state, $this->city);

        if ($city) return $city->name;

        return "";
    }

    public function getStateName(){
        $state = getStateByName($this->state);

        if ($state) return $state->name;

        return "";
    }
}
