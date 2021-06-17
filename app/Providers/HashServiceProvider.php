<?php

namespace App\Providers;

use App\Protocols\Providers\HashProviderProtocol;
use Illuminate\Support\Facades\Hash;

class HashServiceProvider implements HashProviderProtocol {

    public function generateHash($payload): string
    {
      $hashedPayload =   Hash::make($payload);
      return $hashedPayload;
    }

}
