<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class UserRoutesTest extends TestCase
{

    //clear data base before each test
    use RefreshDatabase;


    public function testReturnUserWhitStatus201()
    {
        $response = $this->postJson('/api/user',
                ['name' => 'anyName',
                'email' => 'anyEmail@email.com',
                'password' => 'anyPassword'
                ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'name' => 'anyName',
                'email'=> 'anyEmail@email.com',
            ]);

    }



}

