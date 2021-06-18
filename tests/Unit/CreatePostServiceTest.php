<?php
 namespace  Tests\Unit;

 use App\Services\CreatePostService;
 use App\Services\CreateUserService;
 use Tests\Unit\Fakes\Providers\FakeHashProvider;
 use Tests\Unit\Fakes\Repositories\FakePostRepository;
 use Tests\Unit\Fakes\Repositories\FakeUserRepository;
 use Tests\TestCase;
 use App\Exceptions\AppError;


 class CreatePostServiceTest extends TestCase
 {
     protected $createPost;
     protected $createUser;


     public function setUp(): void
     {
         $this->createUser = new CreateUserService(
             new FakeUserRepository(),
             new FakeHashProvider()
         );

         $fakePostRepository = new FakePostRepository();
         $this->createPost = new CreatePostService($fakePostRepository);

     }

     /**
      * @throws AppError
      */
     public function testCreatePost()
     {

         $user = $this->createUser->execute("anyName","anyEmail","anyPassword");

         $post = $this->createPost->execute("anyTitle","anyContent","anyImage",$user->id);

         $this->assertEquals("anyTitle", $post->title);
     }

     public function testNotCreatePostWhitContentBiggerThan280Chars(){

         $content ="ontrary to popular belief, Lorem Ipsum is not simply random
         text. It has roots in a piece of classical
         Latin literature from 45 BC, making it over 2000 years old. Richard
         McClintock, a Latin professor at Hampden-Sydney College in Virginia,
         looked up one of the more ";

         $this->expectException(AppError::class);

         $user = $this->createUser->execute("anyName","anyEmail","anyPassword");
         $this->createPost->execute("anyTitle",$content,"anyImage",$user->id);

     }




 }
