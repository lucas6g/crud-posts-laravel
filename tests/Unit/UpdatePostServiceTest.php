<?php
namespace  Tests\Unit;

use App\Services\CreatePostService;
use App\Services\CreateUserService;
use App\Services\UpdatePostService;
use Tests\Unit\Fakes\Providers\FakeHashProvider;
use Tests\Unit\Fakes\Repositories\FakePostRepository;
use Tests\Unit\Fakes\Repositories\FakeUserRepository;
use Tests\TestCase;
use App\Exceptions\AppError;


class UpdatePostServiceTest extends TestCase
{
    protected $createPost;
    protected $createUser;
    protected $updatePost;



    public function setUp(): void
    {
        $this->createUser = new CreateUserService(
            new FakeUserRepository(),
            new FakeHashProvider()
        );
        $fakePostRepository = new FakePostRepository();
        $this->createPost = new CreatePostService($fakePostRepository);
        $this->updatePost = new UpdatePostService($fakePostRepository);

    }

    /**
     * @throws AppError
     */
    public function testUpdatePost()
    {

        $user = $this->createUser->execute("anyName","anyEmail","anyPassword");
        $user->id = 10;

        $post = $this->createPost->execute("anyTitle","anyContent",$user->id,"anyuserUrl");
        $post->id = 15;


        $updatedPost = $this->updatePost->execute("new post title","new post content",$post->id,$user->id);

        $this->assertEquals("new post title", $updatedPost->title);
        $this->assertEquals("new post content", $updatedPost->content);
    }


}
