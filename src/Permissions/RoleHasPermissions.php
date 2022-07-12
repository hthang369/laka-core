<?php

namespace Laka\Core\Permissions;

use Laka\Core\Entities\BaseModel;
use Laka\Core\Plugins\Nestedset\NestedSet;
use Laka\Core\Plugins\Nestedset\NodeTrait;

class RoleHasPermissions extends BaseModel
{
    use NodeTrait;

    protected $table = 'role_has_permissions';

    protected $primaryKey = 'section_id';

    protected $fillable = [
        'permission_id',
        'role_id',
    ];

    public function getParentIdName()
    {
        return 'section_'.NestedSet::PARENT_ID;
    }
}
