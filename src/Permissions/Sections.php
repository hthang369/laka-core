<?php

namespace Laka\Core\Permissions;

use Illuminate\Database\Eloquent\Model;
use Laka\Core\Plugins\Nestedset\NodeTrait;

class Sections extends Model
{
    use NodeTrait;

    protected $table = 'sections';

    protected $fillable = [
        'name',
        'code',
        'url',
        'api',
        'description'
    ];

    public static function findCode($name, $columns = ['*'])
    {
        return self::select($columns)->firstWhere('code', $name);
    }

    /**
     * Get the first record matching the attributes or create it.
     *
     * @param  array  $attributes
     * @param  array  $values
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public static function firstOrCreateNestedSet(array $attributes = [], array $values = [])
    {
        $model = self::firstOrNew($attributes, $values);

        if ($model->getKey() != 0) {
            return $model;
        }

        return tap($model, function ($instance) {
            if (method_exists($instance, 'saveAsRoot'))
                return $instance->saveAsRoot();
            else
                return $instance->save();
        });
    }
}
