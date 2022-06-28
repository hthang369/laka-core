<?php
namespace Laka\Core\Forms\Traits;

use Illuminate\Support\Arr;

trait FieldOptions
{
    /**
     * Set single option on the field.
     *
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function setOption($name, $value)
    {
        Arr::set($this->options, $name, $value);

        return $this;
    }

    /**
     * Get field options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get single option from options array. Can be used with dot notation ('attr.class').
     *
     * @param string $option
     * @param mixed|null $default
     * @return mixed
     */
    public function getOption($option, $default = null)
    {
        return Arr::get($this->options, $option, $default);
    }

    /**
     * Get single option from parent options array. Can be used with dot notation ('attr.class').
     *
     * @param string $option
     * @param mixed|null $default
     * @return mixed
     */
    public function getParentConfig($key, $default = null)
    {
        return Arr::wrap($this->parent->getConfig($key, $default));
    }

    protected function combineClass($options, $parentKey = null)
    {
        foreach ($options as $key => $option) {
            if (is_array($option)) {
                if (array_key_exists('class', $option)) {
                    $keyName = join('.', array_filter([$parentKey, $key, 'class']));
                    $this->setOption($keyName, array_css_class($option['class']));
                } else {
                    $this->combineClass($option, $key);
                }
            }
        }
    }
}
