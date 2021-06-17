<?php

namespace App\Exceptions;
use Exception;


class AppError extends Exception{
        public $message;
        public $code;

        public function __construct($message , $code = 400 )
        {
            $this->message = $message;
            $this->code = $code;

        }
    }



