<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

abstract class ModelAbstract extends Model
{
    use HasUuId;
    use SoftDeletes;
    use Userstamps;
}
