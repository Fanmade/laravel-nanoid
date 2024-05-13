<?php

namespace Fanmade\NanoId\Contracts;

interface ValidatorInterface
{
    /**
     * Check if the given ID is valid.
     */
    public function isValid(string $id): bool;
}