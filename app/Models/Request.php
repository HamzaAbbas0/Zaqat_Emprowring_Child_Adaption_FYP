<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Carbon\Carbon;
use App\Models\Service;
use App\Models\User;
use App\Models\RequestMeta;
use App\Models\RequestNote;

class Request extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public static function getTableName()
    {
        return (new self())->getTable();
    }

    public function getFullName() {
        return $this->first_name ." ".$this->last_name;
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function metas()
    {
        return $this->hasMany(RequestMeta::class);
    }

    public function notes()
    {
        return $this->hasMany(RequestNote::class);
    }
}
