<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'shared';
}

