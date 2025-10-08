<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'shared';
}

