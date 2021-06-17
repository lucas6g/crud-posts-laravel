<?php
namespace App\Services;

use App\Exceptions\AppError;
use App\Protocols\Providers\JwtTokenProviderProtocol;
use App\Protocols\Repositories\UserRepositoryProtocol;
use App\Models\User;



class AuthenticateUserService {

    private $userRepository;
    private $jwtTokenProvider;

    public function __construct(
        UserRepositoryProtocol $userRepository,
        JwtTokenProviderProtocol $jwtTokenProvider

    )
    {
        $this->userRepository = $userRepository;
        $this->jwtTokenProvider = $jwtTokenProvider;
    }
    /**
     * @throws AppError
     */
    public function execute($email,$password): User
    {
        $user = $this->userRepository->findByEmail($email);

        if(!$user){
            throw new AppError('invalid email or password combination',401);
        }
        $token = $this->jwtTokenProvider->generateToken($email,$password);

        if(!$token){
            throw new AppError('invalid email or password combination',401);
        }

        $user->token = $token;

        return $user;

    }

}
