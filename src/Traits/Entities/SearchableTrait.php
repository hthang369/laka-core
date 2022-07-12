<?php

namespace Laka\Core\Traits\Entities;

/*
 * A trait to handle use fillable columns
 */

trait SearchableTrait
{
    public function getFillableColumns()
    {
        return $this->fillableColumns ?? ['*'];
    }
}
