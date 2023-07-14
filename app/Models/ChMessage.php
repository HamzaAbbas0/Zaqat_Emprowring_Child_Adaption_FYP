<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ChMessage extends Model
{
    public function from(){
        return $this->belongsTo(User::class, 'from_id', 'id');
    }
}
