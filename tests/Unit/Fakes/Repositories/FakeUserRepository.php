<?php
    namespace Tests\Unit\Fakes\Repositories;

    use App\Models\User;
    use App\Protocols\Repositories\UserRepositoryProtocol;


    class FakeUserRepository  implements UserRepositoryProtocol {
        private $users  = [] ;
        public function create($name, $email, $password): User
        {
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = $password;

            array_push($this->users,$user);

            return $user;
        }

        public function findByEmail($email): ?User
        {
            $user = null;
            foreach ($this->users as $userInArray){
                if($userInArray->email === $email){
                    $user =  $userInArray;
                }
            }

            return $user;
        }





    }
