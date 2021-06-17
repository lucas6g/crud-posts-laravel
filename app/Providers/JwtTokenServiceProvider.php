<?php

namespace App\Providers;


use App\Protocols\Providers\JwtTokenProviderProtocol;


class JwtTokenServiceProvider implements JwtTokenProviderProtocol {

    public function generateToken($email,$password): ?string
    {
       return  auth("api")->attempt(['email'=>$email,'password'=>$password]);

    }

}
