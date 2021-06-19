<?php
namespace  Tests\Unit;

use App\Services\CreatePostService;
use App\Services\CreateUserService;
use App\Services\DeletePostService;
use Tests\Unit\Fakes\Providers\FakeHashProvider;
use Tests\Unit\Fakes\Repositories\FakePostRepository;
use Tests\Unit\Fakes\Repositories\FakeUserRepository;
use Tests\TestCase;
use App\Exceptions\AppError;


class DeletePostServiceTest extends TestCase
{
    protected $createPost;
    protected $createUser;
    protected $delete;
    protected $deletePost;


    public function setUp(): void
    {
        $this->createUser = new CreateUserService(
            new FakeUserRepository(),
            new FakeHashProvider()
        );
        $fakePostRepository = new FakePostRepository();
        $this->createPost = new CreatePostService($fakePostRepository);
        $this->deletePost = new DeletePostService($fakePostRepository);

    }

    /**
     * @throws AppError
     */
    public function testDeletePost()
    {

        $user = $this->createUser->execute("anyName","anyEmail","anyPassword");
        $user->id = 10;

        $post = $this->createPost->execute("anyTitle","anyContent",$user->id,"anyImageUrl");
        $post->id = 15;


       $this->delete->execute($post);



    }


}
