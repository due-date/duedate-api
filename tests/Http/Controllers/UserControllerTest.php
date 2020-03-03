<?php

namespace Tests\Http\Controllers;

use App\Domain\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use JD\Cloudder\CloudinaryWrapper;
use JD\Cloudder\Facades\Cloudder;
use Symfony\Component\HttpFoundation\Response;
use Tests\Fixtures\LogoFixture;
use Tests\Fixtures\PhotoFixture;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * @test
     */
    public function create()
    {
        $user = factory(User::class)->make();

        $cloudinaryWrapper = \Mockery::mock(CloudinaryWrapper::class);
        $cloudinaryWrapper->shouldReceive('getResult')->once()->andReturn(['url' => 'http://url.com.br/path_one/path_two/image_name.png']);
        $cloudinaryWrapper->shouldReceive('getPublicId')->once()->andReturn('image_name');

        Cloudder::shouldReceive('upload')->once()->andReturn($cloudinaryWrapper);


        $response = $this->call('POST', '/users', ['user' => $user->toArray()]);

        $response->assertStatus(Response::HTTP_OK);
        $content = json_decode($response->getContent());
        $this->assertEquals($content->message, 'User created successfully');
    }

    /**
     * @test
     */
    public function update()
    {
        $user = factory(User::class)->create();

        $response = $this->call('PUT', "/users/$user->uuid", ['user' => ['name' => $this->faker->name]]);

        $response->assertStatus(Response::HTTP_OK);
        $content = json_decode($response->getContent());
        $this->assertEquals($content->message, 'User created successfully');
    }

    /**
     * @test
     */
    public function getUser()
    {
        $user = factory(User::class)->create();

        $response = $this->call('GET', "/users?search=uuid:$user->uuid");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'users' => [
                    [
                        'uuid',
                        'name',
                        'email',
                        'active',
                    ]
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function listUserWithoutFilter()
    {
        factory(User::class)->create();

        $response = $this->call('GET', '/users');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'users' => [
                    [
                        'uuid',
                        'name',
                        'email',
                        'active',
                    ]
                ]
            ]
        ]);
    }
}
