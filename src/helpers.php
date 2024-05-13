<?php

use Fanmade\NanoId\Facades\NanoId;

if (!function_exists('nano_id')) {
    function nano_id(?int $length = null, string $alphabet = null): string
    {
        return NanoId::generate($length, $alphabet);
    }
}