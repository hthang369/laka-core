<?php
namespace Laka\Core\Entities;

use Illuminate\Database\Eloquent\Builder;
use Laka\Core\Traits\Pagination\BuildPaginator;

class BaseBuilder extends Builder
{
    use BuildPaginator;
}
