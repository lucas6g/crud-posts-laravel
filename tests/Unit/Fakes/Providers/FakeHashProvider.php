<?php
     namespace Tests\Unit\Fakes\Providers;

     use App\Protocols\Providers\HashProviderProtocol;

     class FakeHashProvider implements HashProviderProtocol{
         public function generateHash($payload): string
         {
          return $payload;
         }
     }


