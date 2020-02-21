<?php

namespace App\Domain\Criterias;

use App\Domain\Enums\ActiveEnum;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ActiveCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('active', ActiveEnum::ACTIVE);
    }
}
