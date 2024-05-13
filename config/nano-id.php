<?php

return [
    /*
     * This will be included in the calculation of the length.
     * If you set the prefix "abc_" and a length of six, the result might look like this: "abc_123
     */
    'prefix' => '',
    /*
     * This will be included in the calculation of the length.
     * If you set the suffix "abc_" and a length of six, the result might look like this: "123:abc"
     */
    'suffix' => '',
    'length' => 21,
    'symbols' => '_-0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
    'generator' => \Fanmade\NanoId\Generator::class,
];