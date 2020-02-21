<?php

namespace App\Domain\Repositories;

use App\Domain\Criterias\ActiveCriteria;
use App\Domain\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Domain\Validators\UserValidator;

class UserRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
        'email',
        'uuid',
        'active'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {
        return UserValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(ActiveCriteria::class);
    }
}
