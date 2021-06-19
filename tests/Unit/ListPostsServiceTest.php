<?php

namespace Tests\Unit;

use App\Services\CreatePostService;
use App\Services\CreateUserService;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Fakes\Providers\FakeHashProvider;
use Tests\Unit\Fakes\Repositories\FakePostRepository;
use App\Services\ListPostsService;
use App\Exceptions\AppError;
use Tests\Unit\Fakes\Repositories\FakeUserRepository;


class ListPostsServiceTest extends TestCase
{
    protected $createPost;
    protected $listPosts;
    protected $createUser;


    public function setUp(): void
    {
        $fakePostRepository = new FakePostRepository();
        $this->createPost = new CreatePostService($fakePostRepository);

        $this->listPosts = new ListPostsService($fakePostRepository);

        $this->createUser = new CreateUserService(new FakeUserRepository(), new FakeHashProvider());

    }

    /**
     * @throws AppError
     */
    public function testListPostsAndHisCreator()
    {
        $user = $this->createUser->execute("anyName", "anyEmail", "anyPassword");

        $post1 = $this->createPost->execute("anyTitle", "anyContent", "anyImage", $user->id);
        $post2 = $this->createPost->execute("anyTitle", "anyContent", "anyImage", $user->id);
        $post3 = $this->createPost->execute("anyTitle", "anyContent", "anyImage", $user->id);

        $post1->user = $user;
        $post2->user = $user;
        $post3->user = $user;


        $posts = $this->listPosts->execute();

        $this->assertContains($post1, $posts);
        $this->assertContains($post2, $posts);
        $this->assertContains($post3, $posts);

        $this->assertEquals(true, $this->assertArrayContainsSameObjectWithValue($posts, "user", $user));

    }

    //function to compare if an object in array has a specific properties
    private function assertArrayContainsSameObjectWithValue($theArray, $attribute, $value): bool
    {
        foreach ($theArray as $arrayItem) {
            if ($arrayItem->$attribute == $value) {
                return true;
            }
        }
        return false;
    }


}
