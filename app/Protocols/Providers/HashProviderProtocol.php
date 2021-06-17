<?php
    namespace App\Protocols\Providers;

    interface HashProviderProtocol{

       function generateHash($payload):string;
    }
