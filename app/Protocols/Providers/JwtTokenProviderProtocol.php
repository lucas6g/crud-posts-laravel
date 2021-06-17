<?php
namespace App\Protocols\Providers;

interface JwtTokenProviderProtocol{

    function generateToken($email,$password):?string;
}
