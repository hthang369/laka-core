<?php
namespace Laka\Core\Forms\Fields;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationRuleParser;
use Illuminate\View\ComponentAttributeBag;
use Laka\Core\Forms\Form;
use Laka\Core\Forms\Traits\FieldOptions;
use Laka\Core\Traits\Grids\CallableData;

abstract class FormField
{
    use CallableData, FieldOptions;
    /**
     * Type of the field.
     *
     * @var string
     */
    protected $type;

    /**
     * Name of the field.
     *
     * @var string
     */
    protected $name;

    /**
     * @var Form
     */
    protected $parent;

    /**
     * All options for the field.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Name of the property for value setting.
     *
     * @var string
     */
    protected $valueProperty = 'value';

    /**
     * Name of the property for default value.
     *
     * @var string
     */
    protected $defaultValueProperty = 'default_value';

    /**
     * @var \Closure|null
     */
    protected $valueClosure = null;

    /**
     * Is default value set?
     *
     * @var bool|false
     */
    protected $hasDefault = false;

    /**
     * @var bool|false
     */
    protected $showLabel = false;

    /**
     * @var bool|false
     */
    protected $showField = false;

    /**
     * @var bool|false
     */
    protected $showError = false;

    abstract protected function getTemplate();
    abstract protected function getAttributes(array $options = []);

    public function __construct($name, $type, Form $parent, array $options = [])
    {
        $this->type = $type;
        $this->name = $name;
        $this->parent = $parent;
        $this->setDefaultOptions($options);
        $this->setupValue();
    }

    public static function make($name, $type, Form $parent, array $options = [])
    {
        $obj = new static($name, $type, $parent, $options);
        return $obj;
    }

    /**
     * Defaults used across all fields.
     *
     * @return array
     */
    private function allDefaults()
    {
        $layout = array_first(array_keys(array_filter($this->getParentConfig('layout'))));
        return [
            'layout' => $layout,
            'wrapper' => [
                'class' => $this->getParentConfig('defaults.wrapper_class'),
                'inline' => ($layout == 'inline')
            ],
            'attr' => [
                'class' => $this->getParentConfig('defaults.field_class'),
                'wrapper' => $this->getParentConfig('defaults.field_wrapper')
            ],
            'help_block' => ['text' => null, 'tag' => 'p', 'attr' => [
                'class' => $this->getParentConfig('defaults.help_block_class')
            ]],
            'value' => null,
            'default_value' => null,
            'label' => null,
            'label_show' => true,
            'field_show' => true,
            'error_show' => true,
            'is_child' => false,
            'label_attr' => ['class' => $this->getParentConfig('defaults.label_class')],
            'label_for' => '',
            'errors' => ['class' => $this->getParentConfig('defaults.error_class')],
            'rules' => [],
            'error_messages' => []
        ];
    }

    /**
     * Default options for field.
     *
     * @return array
     */
    protected function getDefaults()
    {
        return [];
    }

    /**
     * Merge all defaults with field specific defaults and set template if passed.
     *
     * @param array $options
     */
    protected function setDefaultOptions(array $options = [])
    {
        $this->options = $this->parent->mergeOptions($this->allDefaults(), $this->getDefaults());

        $this->options = array_merge_recursive_simple($this->options, $this->getAttributes($options));

        $this->options = $this->parent->mergeOptions($this->options, $this->setupOptions($options));

        $this->setupAttrClass();

        $this->setupLabel();
    }

    private function setupOptions(&$options)
    {
        $this->getAttrOption($options, 'wrapper.class');
        $this->getAttrOption($options, 'attr.class');
        $this->getAttrOption($options, 'help_block.attr.class');
        $this->getAttrOption($options, 'label_attr.class');
        $this->getAttrOption($options, 'errors.class');

        return $options;
    }

    private function getAttrOption(&$options, $key)
    {
        $data = collect(data_get($options, $key));
        if ($data->count() == 0) return;
        $values = $data->prepend('')->filter()->all();
        data_set($options, $key, $values);
    }

    /**
     * Setup the label for the form field.
     *
     * @return void
     */
    protected function setupLabel()
    {
        if ($this->getOption('label') !== null) {
            return;
        }

        if ($langName = $this->parent->languageName) {
            $label = sprintf('%s.%s', $langName, $this->name);
        } else {
            $label = $this->name;
        }

        $this->setOption('label', $this->parent->formatLabel($label));
    }

    /**
     * Setup the value of the form field.
     *
     * @return void
     */
    protected function setupValue()
    {
        $value = $this->getOption($this->valueProperty);
        $isChild = $this->getOption('is_child');

        if ($value instanceof \Closure) {
            $this->valueClosure = $value;
        }

        if ((blank($value) || $value instanceof \Closure) && !$isChild) {
            if ($this instanceof EntityType) {
                $attributeName = $this->name;
            } else {
                $attributeName = $this->getOption('value_property', $this->name);
            }

            $this->setValue($this->getModelValueAttribute($this->parent->getModel(), $attributeName));
        } elseif (!$isChild) {
            $this->hasDefault = true;
        }
    }

    /**
     * Get the attribute value from the model by name.
     *
     * @param mixed $model
     * @param string $name
     * @return mixed
     */
    protected function getModelValueAttribute($model, $name)
    {
        $transformedName = $this->parent->transformToDotSyntax($name);
        if (is_string($model)) {
            return $model;
        } elseif (is_object($model)) {
            return object_get($model, $transformedName);
        } elseif (is_array($model)) {
            return Arr::get($model, $transformedName);
        }
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        if ($this->hasDefault) {
            return $this;
        }

        $closure = $this->valueClosure;

        if ($closure instanceof \Closure) {
            $value = $closure($this, $value ?: null);
        }

        if (!$this->isValidValue($value)) {
            $value = $this->getOption($this->defaultValueProperty);
        }

        $this->options[$this->valueProperty] = $value;

        return $this;
    }

    /**
     * Check if provided value is valid for this type.
     *
     * @return bool
     */
    protected function isValidValue($value)
    {
        return $value !== null;
    }

    private function setupAttrClass()
    {
        $rules = $this->parseRules();
        if ($this->getOption('required') || in_array('required', $rules)) {
            array_forget($this->options, 'required');
            $labelClass = $this->getOption('label_attr.class');
            $this->setOption('label_attr.class', array_merge($labelClass, $this->getParentConfig('defaults.required_class' , 'required')));

            $this->setOption('attr.required', 'required');

            foreach ($rules as $rule) {
                list($rule, $param) = ValidationRuleParser::parse($rule);
                $this->setOption('attr.'.strtolower($rule), head($param));
            }
        }

        $this->combineClass($this->options);
    }

    public function parseRules()
    {
        $rules = $this->getOption('rules');
        return is_string($rules) ? explode('|', $rules) : $rules;
    }

    public function getView()
    {
        $prefix = config('laka-core.prefix');
        $view = 'components.form-field.'.$this->getTemplate();
        $viewName = "{$prefix}::{$view}";
        if (!View::exists($viewName))
            $viewName = 'components.fields.'.$this->getTemplate();
        return $viewName;
    }

    protected function getCompactData()
    {
        $attrs = array_except(get_object_vars($this), ['parent']);
        data_set($attrs, 'showLabel', $this->getOption('label_show'));
        data_set($attrs, 'showField', $this->getOption('field_show'));
        data_set($attrs, 'showError', $this->getOption('error_show'));
        data_set($attrs, 'layout', $this->getOption('layout'));
        array_forget($attrs, 'options.layout');
        return $attrs;
    }

    public function render()
    {
        return view($this->getView(), $this->getCompactData())->render();
    }
}
