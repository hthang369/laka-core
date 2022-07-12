<?php

namespace Laka\Core\Permissions;

use Laka\Core\Contracts\CanCheckInUse;
use Laka\Core\Traits\Common\CheckInUse;
use Laka\Core\Traits\Entities\FullTextSearch;
use Laka\Core\Traits\Entities\SearchableTrait;

class Role extends \Spatie\Permission\Models\Role implements CanCheckInUse
{
    use CheckInUse, FullTextSearch, SearchableTrait;

    protected $dispatchesEvents = [
        'deleting' => ModelDeleting::class,
    ];

    protected $searchable = [
        'name',
        'description'
    ];

    public function findTablesUsingModel()
    {
        return ['user_has_roles.role_id'];
    }

    public function getModelValue()
    {
        return $this->id;
    }
}
