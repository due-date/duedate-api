<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ControllerAbstract;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation;

class ResetPasswordController extends ControllerAbstract
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * @api {post} /auth/reset Reset user'spassword
     * @apiName PostReset
     * @apiGroup Auth
     *
     * @apiParam {string} email
     * @apiParam {string} password
     * @apiParam {string} password_confirmation
     * @apiParam {string} token
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/auth/reset
     *     body:
     *     {
     *       "token": "4bebf893be5db76792a7b1967c580f8829f476cb019ca8a817d2b3c14c2961ef",
     *       "email": "email@example.com",
     *       "password": "secret",
     *       "password_confirmation": "secret"
     *     }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *      {
     *          "type": "success",
     *          "message": "Sua senha foi redefinida com sucesso, autentique novamente !!!",
     *          "data" : []
     *      }
     */
    public function post(Request $request)
    {
        $this->reset($request);

        $this->response['message'] = __('passwords.reset');

        return Response::json($this->response, HttpFoundation\Response::HTTP_OK);
    }
}
