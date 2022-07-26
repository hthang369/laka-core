<?php

namespace Laka\Core\Entities;

use Laka\Core\Observers\BaseModelObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Laka\Core\Traits\Entities\FullTextSearch;
use Laka\Core\Traits\Entities\ListenerModelTrait;
use Laka\Core\Traits\Entities\SearchableTrait;

class BaseModel extends Model
{
    use FullTextSearch, ListenerModelTrait, SearchableTrait;

    const CREATED_USER = 'created_user_id';
    const UPDATED_USER = 'updated_user_id';

    /**
     * @var array
     *
     * get column foreign table:
     * column name alias:foreignTable, foreignKeyPrimaryTable, columnNameForeignTable
     */
    protected $fillableColumns = ['*'];
    protected $auth_user = null;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->registerObserver(BaseModelObserver::class);
        $this->auth_user = Auth::check() ? Auth::user()->id : 0;
    }

    public function setCreatedUpdatedUsers()
    {
        if ($this->exists) {
            $this->setAttributeValue(static::UPDATED_USER, $this->auth_user);
        } else {
            $this->setAttributeValue(static::CREATED_USER, $this->auth_user);
            $this->setAttributeValue(static::UPDATED_USER, $this->auth_user);
        }
    }

    public static function getCreatedUser()
    {
        return static::CREATED_USER;
    }

    public static function getUpdatedUser()
    {
        return static::UPDATED_USER;
    }

    public function setAttributeValue($key, $value)
    {
        if (Schema::hasColumn($this->getTable(), $key)) {
            return parent::setAttribute($key, $value);
        }
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new BaseBuilder($query);
    }
}
