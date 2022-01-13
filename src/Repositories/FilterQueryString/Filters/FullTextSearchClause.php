<?php

namespace Laka\Core\Repositories\FilterQueryString\Filters;

use Illuminate\Database\Eloquent\Builder;
use Laka\Core\Traits\Entities\FullTextSearch;

class FullTextSearchClause extends BaseClause
{
    use FullTextSearch;

    public function apply($query): Builder
    {
        $this->scopeFullTextSearch($query, $this->column, $this->values);

        return $query;
    }

    public function validate($value): bool
    {
        if (is_null($value)) {
            return false;
        }

        return true;
    }
}
