<?php


namespace App\Domain\Services;

use App\Domain\Models\User;
use App\Domain\Repositories\UserRepository;
use Carbon\Carbon;
use Prettus\Repository\Criteria\RequestCriteria;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService implements ServiceInterface
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $attributes): User
    {
        $attributes['password']          = bcrypt($attributes['password']);
        $attributes['email_verified_at'] = Carbon::create();

        return $this->repository->create($attributes);
    }

    public function findOneBy($field, $value): User
    {
        $user = $this->repository->findByField($field, $value)->first();

        if (!$user instanceof User) {
            throw new NotFoundHttpException(__('exception.user.not_found'));
        }

        return $user;
    }

    public function update(User $user, array $attributes): User
    {
        unset($attributes['uuid']);
        $attributes['password'] = isset($attributes['password']) ? bcrypt($attributes['password']) : $user->password;

        return $this->repository->update($attributes, $user->id);
    }

    public function listByRequestCriteria(): UserRepository
    {
        $this->repository->pushCriteria(app(RequestCriteria::class));

        return $this->repository;
    }
}
