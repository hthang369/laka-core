<?php
namespace Laka\Core\Entities;

use Illuminate\Database\Eloquent\Builder;
use Laka\Core\Traits\BuildPaginator;

class BaseBuilder extends Builder
{
    use BuildPaginator;
}
