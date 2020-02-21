<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResourceCollection;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends ControllerAbstract
{
    /**
     * @api {post} /users Create new user
     * @apiName PostUser
     * @apiGroup Users
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/users
     *     body:
     *     {
     *      "user": {
     *          "name": "José de Arimateia",
     *          "cpf": "29420039578",
     *          "email": "email@example.com",
     *          "password": "secret"
     *      }
     *     }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *      {
     *          "type": "success",
     *          "message": "Usuário cadastrado com sucesso !!!",
     *          "data" : {
     *              "uuid":"07a83d66-e326-4859-b4df-079b7eee65bc",
     *          }
     *      }
     */
    public function post(Request $request)
    {
        try {
            $user = $this->userService->create($request->get('user'));

            $this->response = [
                'message' => __('message.user.created_successfully'),
                'data'    => ['uuid' => $user->uuid]
            ];
        } catch (ValidatorException $exception) {
            return $this->buildResponseError($exception, HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (NotFoundHttpException $exception) {
            return $this->buildResponseError($exception, HttpFoundation\Response::HTTP_NOT_FOUND);
        }
        return Response::json($this->response, HttpFoundation\Response::HTTP_OK);
    }

    /**
     * @api {put} /users/:uuid Edit user
     * @apiName PutUser
     * @apiGroup Users
     *
     * @apiParam status ACTIVE|INACTIVE
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/users/07a83d66-e326-4859-b4df-079b7eee65bc
     *     body:
     *     {
     *      "user": {
     *          "name": "José de Arimateia",
     *          "cpf": "29420039578",
     *          "email": "email@example.com",
     *          "active": "1",
     *     }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *      {
     *          "type": "success",
     *          "message": "Usuário alterado com sucesso !!!",
     *          "data" : {
     *              "uuid":"07a83d66-e326-4859-b4df-079b7eee65bc",
     *          }
     *      }
     */
    public function put(Request $request)
    {
        try {
            $user = $this->userService->findOneBy('uuid', $request->route('uuid'));

            $user = $this->userService->update($user, $request->get('user'));

            $this->response = [
                'message' => __('message.user.updated_successfully'),
                'data'    => ['uuid' => $user->uuid]
            ];
        } catch (ValidatorException $exception) {
            return $this->buildResponseError($exception, HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (NotFoundHttpException $exception) {
            return $this->buildResponseError($exception, HttpFoundation\Response::HTTP_NOT_FOUND);
        }

        return Response::json($this->response, HttpFoundation\Response::HTTP_OK);
    }

    /**
     * @api {get} /users Return a list of user
     * @apiName GetUser
     * @apiGroup Users
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/users/list?search=jose%20Doe
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/users/lists?search=john@gmail.com&searchFields=email:=
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/users/list?search=name:John Doe;email:john@gmail.com
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/users/list?search=cpf:20922394832
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/users/list?search=name:John;email:john@gmail.com&searchFields=name:like;email:=
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *      {
     *          "type": "success",
     *          "message": "",
     *          "data" : {
     *              "users": [{
     *                  "uuid":"07a83d66-e326-4859-b4df-079b7eee65bc",
     *                  "name": "José Maria"
     *                  "cpf": "28311194930",
     *                  "email": "jose@maria.com"
     *              }]
     *          }
     *      }
     */
    public function get(Request $request)
    {
        if ($request->query('page')) {
            $users = $this->userService->listByRequestCriteria()->paginate();
        } else {
            $users = $this->userService->listByRequestCriteria()->get();
        }

        $this->response['data'] = ['users' => new UserResourceCollection($users)];

        return Response::json($this->response, HttpFoundation\Response::HTTP_OK);
    }
}
