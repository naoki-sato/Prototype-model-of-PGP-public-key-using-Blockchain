<?php

namespace App\Exceptions;


use Exception;

class CommandNotFoundException extends Exception
{

    public function __construct($cmdName = null)
    {
        parent::__construct($cmdName . ' command not found', 800);
    }

}