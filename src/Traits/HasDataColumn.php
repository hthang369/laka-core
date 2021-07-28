<?php

namespace Laka\Core\Traits;

use Illuminate\Database\Eloquent\Model;
use Laka\Core\Helpers\DataColumn;
use Laka\Core\Helpers\LookupData;

trait HasDataColumn
{
    private function getTemplateFields()
    {
        return [
            'key' => '',
            'label' => '',
            'headerTitle' => '',
            'class' => '',
            'dataType' => 'string',
            'sortable' => true,
            'filtering' => false,
            'tdClass' => '',
            'thClass' => '',
            'thStyle' => '',
            'variant' => '',
            'tdAttr' => [],
            'isRowHeader' => false,
            'cell'  => '',
            'visible' => true,
            'stickyColumn' => false,
            'lookup' => [
                'dataSource' => null,
                'displayExpr' => '',
                'valueExpr' => ''
            ]
        ];
    }

    private function getTemplateFieldButton()
    {
        return [
            'key' => '',
            'label' => '',
            'class' => '',
            'title'  => '',
            'icon'  => '',
            'visible' => true
        ];
    }

    private function getTemplatePagination()
    {
        return [
            'total' => 0,
            'pages' => 0,
            'currentPage' => 0,
            'from' => 0,
            'to' => 0
        ];
    }

    private function getLabel($text)
    {
        return title_case(snake_case(studly_case($text), ' '));
    }

    public function getFields($fields, $items)
    {
        if (is_null($fields)) {
            $object = head($items);
            if ($object instanceof Model)
                $object = $object->getAttributes();
            $fields = array_keys($object);
        }

        return array_map(function($field) {
            $template = $this->getTemplateFields();
            if (is_string($field)) {
                data_set($template, 'key', $field);
                data_set($template, 'label', $this->getLabel($field));
            } else {
                $template = array_merge($template, $field);
                if (blank($template['label'])) {
                    data_set($template, 'label', $this->getLabel($template['key']));
                }
                if (!is_null(data_get($template, 'lookup.dataSource'))) {
                    data_set($template, 'lookup', LookupData::make($template['lookup']));
                }
            }
            $dataFields = DataColumn::make($template);
            return $dataFields;
        }, $fields);
    }

    public function getPagination($pagination)
    {
        return array_merge($this->getTemplatePagination(), $pagination);
    }

    public function getField($fieldName, $caption, $options = [])
    {
        $fields = array_merge($this->getTemplateFields(), ['key' => $fieldName, 'label' => $caption]);
        return array_merge($fields, $options);
    }

    public function getFieldButton($fieldName, $caption, $options = [])
    {
        $fields = array_merge($this->getTemplateFieldButton(), ['key' => $fieldName, 'label' => $caption]);
        return array_merge($fields, $options);
    }
}
