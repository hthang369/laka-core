<?php

namespace Laka\Core\Plugins\Nestedset;

use Illuminate\Database\Schema\Blueprint;

class NestedSet
{
    /**
     * The name of default lft column.
     */
    const LFT = 'left';

    /**
     * The name of default rgt column.
     */
    const RGT = 'right';

    /**
     * The name of default parent id column.
     */
    const PARENT_ID = 'parent_id';

    /**
     * Insert direction.
     */
    const BEFORE = 1;

    /**
     * Insert direction.
     */
    const AFTER = 2;

    /**
     * Add default nested set columns to the table. Also create an index.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     */
    public static function columns(Blueprint $table, $options = [])
    {
        list($parent, $left, $right) = $defaultColumns = static::getDefaultColumns($options);
        $parentColumn = $table->unsignedInteger($parent)->nullable();
        $leftColumn = $table->unsignedInteger($left)->default(0);
        $rightColumn =  $table->unsignedInteger($right)->default(0);
        if (array_has($options, 'after')) {
            $parentColumn->after($options['after']);
            $leftColumn->after($parentColumn->name);
            $rightColumn->after($leftColumn->name);
        }

        $table->index($defaultColumns);
    }

    /**
     * Drop NestedSet columns.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     */
    public static function dropColumns(Blueprint $table, $options = [])
    {
        $columns = static::getDefaultColumns($options);

        $table->dropIndex($columns);
        $table->dropColumn($columns);
    }

    /**
     * Get a list of default columns.
     *
     * @return array
     */
    public static function getDefaultColumns($options = [])
    {
        return [
            data_get($options, self::PARENT_ID, self::PARENT_ID),
            data_get($options, self::LFT, self::LFT),
            data_get($options, self::RGT, self::RGT)
        ];
    }

    /**
     * Replaces instanceof calls for this trait.
     *
     * @param mixed $node
     *
     * @return bool
     */
    public static function isNode($node)
    {
        return is_object($node) && in_array(NodeTrait::class, (array)$node);
    }

}
