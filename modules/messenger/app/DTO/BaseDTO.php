<?php

namespace Modules\messenger\app\DTO;

use Illuminate\Support\Str;

class BaseDTO
{
    public function toArray()
    {
        $array = [];

        foreach (get_object_vars($this) as $key => $value) {
            $array[Str::snake($key)] = $value;
        }

        return $array;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

}
