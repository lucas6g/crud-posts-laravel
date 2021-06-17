<?php

namespace Tests\Unit;

use App\Exceptions\AppError;
use App\Services\AuthenticateUserService;
use PHPUnit\Framework\TestCase;
use App\Services\CreateUserService;
use Tests\Unit\Fakes\Providers\FakeHashProvider;
use Tests\Unit\Fakes\Providers\FakeJwtTokenProvider;
use Tests\Unit\Fakes\Repositories\FakeUserRepository;


class AuthenticateUserServiceTest extends TestCase
{

    protected $createUser;
    protected $authenticateUser;

    public function setUp(): void
    {
        $fakeUserRepository = new FakeUserRepository();
        $this->createUser = new CreateUserService(
          $fakeUserRepository,
          new FakeHashProvider()
        );
        $this->authenticateUser = new AuthenticateUserService(
           $fakeUserRepository,
            new FakeJwtTokenProvider()
        );
    }
    /**
     * @throws AppError
     */
    public function testAuthenticateUser()
    {
        $user = $this->createUser->execute("anyName","anyEmail","anyPassword");
        $response = $this->authenticateUser->execute($user->email,$user->password);
        $this->assertObjectHasAttribute("token",$response);

    }

    /**
     * @throws AppError
     */
    public function testNotAuthenticateUserWhitWrongPassword()
    {
        $wrongPassword = "wrongPassword";
        $this->expectException(AppError::class);
        $user = $this->createUser->execute("anyName","anyEmail","anyPassword");
        $this->authenticateUser->execute($user->email,$wrongPassword);

    }

    public function testNotAuthenticateUserIfItDoesNotExits()
    {
        $this->expectException(AppError::class);
        $this->authenticateUser->execute("anyEmail","anyPassword");
    }

}
