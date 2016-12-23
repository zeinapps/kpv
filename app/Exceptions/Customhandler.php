<?php

namespace App\Exceptions;


use RuntimeException;

class Customhandler extends RuntimeException
{
    public function __construct($message = "", $callback = null) {
        if(!$callback){
            $callback = url()->previous();
        }
        echo $message;
//        redirect(url()->previous())->withErrors([$message])
//                        ->withInput();
        exit();
    }

}
