<?php
    namespace App\Repositories;
    use App\Models\User;
    use App\Protocols\Repositories\UserRepositoryProtocol;

    class EloquentUserRepository implements UserRepositoryProtocol{

        public function create($name, $email, $password): User
        {
            $user = new User();

            $user->name = $name;
            $user->email = $email;
            $user->password = $password;

            $user->save();

            return $user;
        }


        public function findByEmail($email): ?User
        {
            $user =  User::where('email',$email )->get()->first();

            return $user;

        }

    }

