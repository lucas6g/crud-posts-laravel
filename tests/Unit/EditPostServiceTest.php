<?php
namespace  Tests\Unit;

use App\Services\CreatePostService;
use App\Services\CreateUserService;
use App\Services\EditPostService;
use Tests\Unit\Fakes\Providers\FakeHashProvider;
use Tests\Unit\Fakes\Repositories\FakePostRepository;
use Tests\Unit\Fakes\Repositories\FakeUserRepository;
use Tests\TestCase;
use App\Exceptions\AppError;


class EditPostServiceTest extends TestCase
{
    protected $createPost;
    protected $createUser;
    protected $editPost;


    public function setUp(): void
    {
        $this->createUser = new CreateUserService(
            new FakeUserRepository(),
            new FakeHashProvider()
        );
        $fakePostRepository = new FakePostRepository();
        $this->createPost = new CreatePostService($fakePostRepository);
        $this->editPost = new EditPostService($fakePostRepository);

    }

    /**
     * @throws AppError
     */
    public function testEditPost()
    {

        $user = $this->createUser->execute("anyName","anyEmail","anyPassword");
        $user->id = 10;
        $post = $this->createPost->execute("anyTitle","anyContent",$user->id,"anyuserUrl");
        $post->id = 15;

        $postData = $this->editPost->execute($post->id,$user->id);
        $this->assertEquals($post->id, $postData->id);
        $this->assertEquals($post->user_id, $postData->user_id);
    }


}
