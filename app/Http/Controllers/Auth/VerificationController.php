<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Models\User;
use App\Http\Controllers\ControllerAbstract;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VerificationController extends ControllerAbstract
{
    use VerifiesEmails;

    /**
     * @api {get} /auth/verify Verify user's email
     * @apiName PostVerify
     * @apiGroup Auth
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/auth/verify?uuid=J07a83d66-e326-4859-b4df-079b7eee65bc
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *      {
     *          "type": "success",
     *          "message": "Email verificado com sucesso !!!",
     *          "data" : []
     *      }
     */
    public function verify(Request $request)
    {
        try {
            $user = $this->userService->findOneBy('uuid', $request->get('uuid'));

            if ($user instanceof User && $user->markEmailAsVerified()) {
                event(new Verified($user));
            }

            $this->response['message'] = __('message.user.verified');
        } catch (NotFoundHttpException $exception) {
            return $this->buildResponseError($exception, HttpFoundation\Response::HTTP_NOT_FOUND);
        }

        return Response::json($this->response, HttpFoundation\Response::HTTP_OK);
    }

    /**
     * @api {post} /auth/resend Resend email for verification
     * @apiName PostResend
     * @apiGroup Auth
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/auth/resend
     *      body: {
     *          "email": "example@gmail.com"
     *     }
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *      {
     *          "type": "success",
     *          "message": "Email reenviado com sucesso !!!",
     *          "data" : []
     *      }
     */
    public function resend(Request $request)
    {
        $user = $this->userService->findOneBy('email', $request->get('email'));

        if ($user->hasVerifiedEmail()) {
            $this->response['type']    = 'error';
            $this->response['message'] = __('message.user.already_verified');
            return Response::json($this->response, HttpFoundation\Response::HTTP_BAD_REQUEST);
        }

        $user->sendEmailVerificationNotification();
        $this->response['message'] = __('message.user.email_resend');

        return Response::json($this->response, HttpFoundation\Response::HTTP_OK);
    }
}
