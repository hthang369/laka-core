<?php

/*
 * You can place your custom package configuration in here.
 */

use Laka\Core\Components\Common\Alert;
use Laka\Core\Components\Forms\Checkbox;
use Laka\Core\Components\Forms\Datepicker;
use Laka\Core\Components\Forms\Group;
use Laka\Core\Components\Forms\Input;
use Laka\Core\Components\Forms\Label;
use Laka\Core\Components\Forms\Radio;
use Laka\Core\Components\Forms\Select;
use Laka\Core\Components\Tables\Pagination;
use Laka\Core\Components\Tables\Table;
use Laka\Core\Components\Tables\TableColumn;
use Laka\Core\Components\Tables\TableFilter;
use Laka\Core\Components\Tables\TableRow;
use Laka\Core\Components\Tables\TableSort;

return [
    'prefix' => 'bootstrap',
    'components' => [
        'datepicker' => [
            'view'  => 'components.forms.datepicker',
            'class' => Datepicker::class
        ],
        'form-group' => [
            'view'  => 'components.forms.group',
            'class' => Group::class
        ],
        'form-input' => [
            'view'  => 'components.forms.input',
            'class' => Input::class
        ],
        'form-label' => [
            'view'  => 'components.forms.label',
            'class' => Label::class
        ],
        'form-select' => [
            'view'  => 'components.forms.select',
            'class' => Select::class
        ],
        'form-checkbox' => [
            'view'  => 'components.forms.checkbox',
            'class' => Checkbox::class
        ],
        'form-radio' => [
            'view'  => 'components.forms.radio',
            'class' => Radio::class
        ],
        'table' => [
            'view'  => 'components.tables.table',
            'class' => Table::class
        ],
        'table-row' => [
            'view'  => 'components.tables.table-row',
            'class' => TableRow::class
        ],
        'table-column' => [
            'view'  => 'components.tables.table-column',
            'class' => TableColumn::class
        ],
        'table-sort' => [
            'view'  => 'components.tables.table-sort',
            'class' => TableSort::class
        ],
        'table-filter' => [
            'view'  => 'components.tables.table-filter',
            'class' => TableFilter::class
        ],
        'pagination' => [
            'view'  => 'components.tables.pagination',
            'class' => Pagination::class
        ],
        'alert' => [
            'view'  => 'components.common.alert',
            'class' => Alert::class
        ],

    ],
    'form-components' => [
        'bsInput' => [
            'view'      => Input::class,
            'params'    => ['name', 'type', 'class', 'groupClass', 'icon', 'prepent', 'size', 'value']
        ],
        'bsCheckbox' => [
            'view'      => Checkbox::class,
            'params'    => ['name', 'label', 'custom', 'checked']
        ],
        'bsRadio' => [
            'view'      => Radio::class,
            'params'    => ['name', 'label', 'custom', 'value', 'checked']
        ]
    ]
];
