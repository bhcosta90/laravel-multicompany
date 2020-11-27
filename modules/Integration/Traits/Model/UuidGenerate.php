<?php

namespace Modules\Integration\Traits\Model;

use Illuminate\Support\Str;

trait UuidGenerate {
    protected function getField()
    {
        return 'uuid';
    }

    public static function bootUuidGenerate()
    {
        static::creating(function($obj){
            $field = $obj->getField();
            $obj->$field = Str::uuid();
        });
    }
}