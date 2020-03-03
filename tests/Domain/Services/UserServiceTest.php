<?php

namespace Tests\Domain\Services;

use App\Domain\Models\User;
use App\Domain\Repositories\UserRepository;
use App\Domain\Services\UserService;
use Illuminate\Http\Request;
use JD\Cloudder\CloudinaryWrapper;
use JD\Cloudder\Facades\Cloudder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\Fixtures\PhotoFixture;
use Tests\TestCase;


class UserServiceTest extends TestCase
{
    /**
     * @var UserService
     */
    private $userService;

    public function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService(new UserRepository($this->app));
    }

    /**
     * @test
     */
    public function create()
    {
        $user = factory(User::class)->make();

        $cloudinary = \Mockery::mock(CloudinaryWrapper::class);
        $cloudinary->shouldReceive('getResult')->once()->andReturn(['url' => 'https://res.cloudinary.com/path_one/path_two/image_name.png']);
        $cloudinary->shouldReceive('getPublicId')->once()->andReturn('image_name');

        Cloudder::shouldReceive('upload')->once()->andReturn($cloudinary);

        $user = $this->userService->create($user->toArray());

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @test
     */
    public function findOneUser()
    {
        $user = factory(User::class)->create();

        $user = $this->userService->findOneBy('uuid', $user->uuid);

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @test
     */
    public function notFindOneUser()
    {
        $user = factory(User::class)->make();

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('Usuário não encontrado');

        $this->userService->findOneBy('uuid', $user->uuid);
    }

    /**
     * @test
     */
    public function update()
    {
        $user = factory(User::class)->create();

        $user = $this->userService->update($user, ['name' => 'José Maria']);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('José Maria', $user->name);
    }

    /**
     * @test
     */
    public function shouldUpdateUser()
    {
        $user = factory(User::class)->create();

        $name = $this->faker->name;
        $data = ['name' => $name];

        $user = $this->userService->update($user, $data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($name, $user->name);
    }

    /**
     * @test
     */
    public function shouldListUserByUuid()
    {
        $user = factory(User::class)->create();

        $request = new Request();
        $request->query->add(['search' => 'uuid:' . $user->uuid]);
        $this->app->instance(Request::class, $request);

        $users = $this->userService->listByRequestCriteria()->get();

        $this->assertCount(1, $users);
        $users->each(function ($user) {
            $this->assertInstanceOf(User::class, $user);
        });
    }
}
