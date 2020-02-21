<?php

namespace Tests\Http\Controllers\V1\Auth;

use App\Domain\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * @test
     */
    public function signInSuccessfully()
    {
        $user = factory(User::class)->create();

        $response = $this->call('POST', '/auth/sign-in', [
            'email'    => $user->email,
            'password' => '123456',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['data' => ['access_token', 'token_type', 'expires_in']]);
    }

    /**
     * @test
     */
    public function signInInvalidPassword()
    {
        $this->withoutMiddleware();
        $user = factory(User::class)->create();

        $response = $this->call('POST', '/auth/sign-in', [
            'credential' => $user->email,
            'password'   => '123457',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function whoIam()
    {
        $this->withoutMiddleware();

        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->call('GET', '/auth/me');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'user' => [
                    'name',
                    'email',
                    'uuid',
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function whoIamNoAuth()
    {
        $this->withMiddleware();

        $response = $this->call('GET', '/auth/me');

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * @test
     */
    public function signOut()
    {
        $this->withoutMiddleware();

        auth('api')->login(factory(User::class)->create());

        $response = $this->call('POST', '/auth/sign-out');

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function refresh()
    {
        $this->withoutMiddleware();

        auth('api')->login(factory(User::class)->create());

        $response = $this->call('POST', '/auth/refresh');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['data' => ['access_token', 'token_type', 'expires_in']]);
    }
}
