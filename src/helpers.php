<?php

use Fanmade\NanoId\Facades\NanoID;

if (!function_exists('nano_id')) {
    function nano_id(?int $length = null, ?string $alphabet = null): string
    {
        return NanoID::generate($length, $alphabet);
    }
}
