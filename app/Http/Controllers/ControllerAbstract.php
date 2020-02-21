<?php

namespace App\Http\Controllers;

use App\Domain\Containers\ServiceContainer;
use App\Domain\Services\UserService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Response;

abstract class ControllerAbstract extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $response;

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(ServiceContainer $serviceContainer)
    {
        $this->response = [
            'type'    => 'success',
            'message' => null,
            'data'    => [],
        ];

        $this->userService = $serviceContainer->getService(UserService::class);
     }

    protected function buildResponseError(\Exception $exception, int $codeStatus): JsonResponse
    {
        $this->response['type']    = 'error';
        $this->response['message'] = method_exists($exception, 'getMessageBag') ?
            $exception->getMessageBag()->first() : $exception->getMessage();
        $this->response['data']    = method_exists($exception, 'getParams') ? $exception->getParams() : null;

        return Response::json($this->response, $codeStatus);
    }

    /**
     * @apiDefine AuthorizationHeader
     *
     * @apiHeader {String} Authorization Bearer Access Authentication token JWT
     */
}
