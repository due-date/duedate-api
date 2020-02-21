<?php

namespace Tests\Http\Controllers\V1\Auth;

use App\Domain\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class VerificationControllerTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * @test
     */
    public function shouldVerifyEmail()
    {
        $user = factory(User::class)->create();

        $response = $this->call('GET', '/auth/verify', ['uuid' => $user->uuid]);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function shouldResendEmail()
    {
        $user = factory(User::class)->create(['email_verified_at' => null]);

        $response = $this->call('POST', '/auth/resend', ['email' => $user->email]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
