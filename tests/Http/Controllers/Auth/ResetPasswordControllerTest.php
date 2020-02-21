<?php

namespace Tests\Http\Controllers\V1\Auth;

use App\Domain\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Passwords\PasswordBroker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * @test
     */
    public function shouldResetPassword()
    {
        $user = factory(User::class)->create();
        $token = app(PasswordBroker::class)->createToken($user);

        DB::table(config('auth.passwords.users.table'))->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => Carbon::create(),
        ]);

        $response = $this->call('POST', '/auth/reset', [
            'email'                 => $user->email,
            'token'                 => $token,
            'password'              => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
