<?php
namespace Tests\Unit\Fakes\Providers;

use App\Protocols\Providers\JwtTokenProviderProtocol;

class FakeJwtTokenProvider implements JwtTokenProviderProtocol{


    public function generateToken($email,$password): ?string
    {
       if($password === "wrongPassword"){
           return null;
       }
       return "jwtToken";
    }
}

