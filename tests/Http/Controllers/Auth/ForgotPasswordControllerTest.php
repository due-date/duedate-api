<?php

namespace Tests\Http\Controllers\V1\Auth;

use App\Domain\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * @test
     */
    public function shouldSendEmailToResetPassword()
    {
        $user = factory(User::class)->create();

        $response = $this->call('POST', '/auth/forgot', [
            'email' => $user->email,
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
