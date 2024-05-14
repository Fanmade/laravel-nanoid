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
    'include_prefix_in_length' => true, // should the length of the prefix be included in the size limitation
    'include_suffix_in_length' => true, // should the length of the suffix be included in the size limitation
    'size' => 21,
    'alphabet' => '_-0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
    'generator' => \Fanmade\NanoId\Generator::class,
];