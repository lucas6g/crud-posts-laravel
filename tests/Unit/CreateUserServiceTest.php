<?php

namespace Tests\Unit;


use App\Exceptions\AppError;
use PHPUnit\Framework\TestCase;
use App\Services\CreateUserService;
use Tests\Unit\Fakes\Providers\FakeHashProvider;
use Tests\Unit\Fakes\Repositories\FakeUserRepository;


class CreateUserServiceTest extends TestCase
{

    protected $createUser;

    public function setUp(): void
    {
        $this->createUser = new CreateUserService(
            new FakeUserRepository(),
            new FakeHashProvider()
        );
    }

    /**
     * @throws AppError
     */
    public function testCreateUser()
    {


        $user = $this->createUser->execute("anyName", "anyEmail", "anyPassword");
        $this->assertEquals("anyName", $user->name);


    }

    /**
     * @throws AppError
     */
    public function testNotCreateUserWhitSameEmail()
    {
        $userEmail = "anyEmail";

        $this->expectException(AppError::class);
        $this->createUser->execute("anyName", $userEmail, "anyPassword");
        $this->createUser->execute("anyName", $userEmail, "anyPassword");

    }
}
