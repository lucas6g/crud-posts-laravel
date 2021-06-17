<?php
    namespace App\Services;

    use App\Exceptions\AppError;
    use App\Models\User;
    use App\Protocols\Providers\HashProviderProtocol;
    use App\Protocols\Repositories\UserRepositoryProtocol;

    class CreateUserService {

        private $userRepository;
        private $hashProvider;

        public function __construct(
            UserRepositoryProtocol $userRepositoryProtocol,
            HashProviderProtocol $hashProvider
        )
        {
            $this->userRepository = $userRepositoryProtocol;
            $this->hashProvider = $hashProvider;
        }


        /**
         * @throws AppError
         */
        public function execute($name, $email, $password): User{

            $user = $this->userRepository->findByEmail($email);

            if($user){
                throw new AppError('email already in use',401);
            }

            $hashedPassword = $this->hashProvider->generateHash($password);

            return  $this->userRepository->create($name,$email,$hashedPassword);

        }

    }
