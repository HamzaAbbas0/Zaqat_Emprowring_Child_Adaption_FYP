<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class RequestMeta extends Model
{

    public static function getTableName()
    {
        return (new self())->getTable();
    }

    
}
