<?php
    namespace App\Protocols\Repositories;

    use App\Models\User;

    interface UserRepositoryProtocol{

       function create($name,$email,$password):User;
       function findByEmail($email):?User;

    }
