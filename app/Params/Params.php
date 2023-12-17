<?php

namespace App\Params;

class Params
{
    public function __toString()
    {
        return json_encode($this);
    }
}
