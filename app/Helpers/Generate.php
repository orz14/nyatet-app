<?php

namespace App\Helpers;

class Generate
{
    public static function randomString($length): string
    {
        return bin2hex(random_bytes($length / 2));
    }
}
