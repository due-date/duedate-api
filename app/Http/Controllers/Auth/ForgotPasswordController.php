<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ControllerAbstract;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation;

class ForgotPasswordController extends ControllerAbstract
{
    use SendsPasswordResetEmails;

    /**
     * @api {post} /auth/forgot Reset password and send a email
     * @apiName PostForgot
     * @apiGroup Auth
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/auth/forgot
     *      body: {
     *          "email": "example@gmail.com",
     *     }
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *      {
     *          "type": "success",
     *          "message": "Email enviado com sucesso para sua caixa postal !!!",
     *          "data":[]
     *      }
     */
    public function post(Request $request)
    {
        $this->response['message'] = $this->sendResetLinkEmail($request);

        return Response::json($this->response, HttpFoundation\Response::HTTP_OK);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return trans($response);
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return trans($response);
    }
}
