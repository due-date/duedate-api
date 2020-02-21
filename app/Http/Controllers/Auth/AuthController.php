<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ControllerAbstract;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends ControllerAbstract
{

    /**
     * @api {post} /auth/sign-in Sign In user
     * @apiName PostSignIn
     * @apiGroup Auth
     *
     * @apiParam {string} email
     * @apiParam {string} password
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/auth/sign-in
     *     body:
     *     {
     *       "email": "email@example.com",
     *       "password": "secret"
     *     }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *      {
     *          "type": "success",
     *          "message": null,
     *          "data" : {
     *              "access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9nYXAtYXBpLmxvY2FsXC9hdXRoXC9zaWduLWluIiwiaWF0IjoxNTM4MDk4MTE2LCJleHAiOjE1MzgxMDE3MTYsIm5iZiI6MTUzODA5ODExNiwianRpIjoicmZnaVJQd3hUNmkweFZycSIsInN1YiI6MSwicHJ2IjoiZmNkODY4YmRiMDY0MWVlODcwOGE2NDVlZmY1ODAzODAyZmRiZGUzOCJ9.F8N4Ep-by0LYHpVfKzwMcVJ2nksgrFa8D-FfKIOaVU8",
     *              "token_type":"bearer",
     *              "expires_in":3600
     *          }
     *      }
     */
    public function signIn()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            $this->response['type']    = 'error';
            $this->response['message'] = trans('exception.auth.unauthorized');

            return response()->json($this->response, Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @api {get} /auth/me Return authenticated user data
     * @apiName GetMe
     * @apiGroup Auth
     *
     * @apiUse AuthorizationHeader
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/auth/me
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *  "type": "success",
     *  "message": null,
     *  "data" : {
     *      "user": {
     *          "name": "Ian Torres",
     *          "email": "iantorres@exmple.com",
     *          "cpf": "39200029399",
     *          "uuid": "888286e5-e508-4f28-a98d-1c56d2f036b0",
     *          "role": {
     *              "uuid": "888286e5-e508-4f28-a98d-1c56d2f036b0",
     *              "name": "admin",
     *              "descriotion": "This role is...."
     *          }
     *      }
     *  }
     */
    public function me()
    {
        $this->response['data'] = ['user' => new UserResource(auth('api')->user())];

        return response()->json($this->response);
    }

    /**
     * @api {post} /auth/sign-out Sign Out user
     * @apiName PostSignOut
     * @apiGroup Auth
     *
     * @apiUse AuthorizationHeader
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/auth/sign-out
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *      {
     *          "type": "success",
     *          "message": "Usuário deslogado com sucesso !!!"
     *      }
     */
    public function signOut()
    {
        auth('api')->logout();

        $this->response['message'] = trans('auth.logout.successfully');

        return response()->json($this->response);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * @api {post} /auth/refresh Refresh user's token
     * @apiName PostRefresh
     * @apiGroup Auth
     *
     * @apiUse AuthorizationHeader
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/auth/refresh
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *      {
     *          "type": "success",
     *          "message": null,
     *          "data" : {
     *              "access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9nYXAtYXBpLmxvY2FsXC9hdXRoXC9zaWduLWluIiwiaWF0IjoxNTM4MDk4MTE2LCJleHAiOjE1MzgxMDE3MTYsIm5iZiI6MTUzODA5ODExNiwianRpIjoicmZnaVJQd3hUNmkweFZycSIsInN1YiI6MSwicHJ2IjoiZmNkODY4YmRiMDY0MWVlODcwOGE2NDVlZmY1ODAzODAyZmRiZGUzOCJ9.F8N4Ep-by0LYHpVfKzwMcVJ2nksgrFa8D-FfKIOaVU8",
     *              "token_type":"bearer",
     *              "expires_in":3600
     *          }
     *      }
     */
    protected function respondWithToken($token)
    {
        $this->response['message'] = __('auth.successfully');
        $this->response['data']    = [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ];

        return response()->json($this->response);
    }
}
