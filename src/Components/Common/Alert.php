<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

/**
 * Provide contextual feedback messages for typical user actions with the handful of available and flexible alert messages.
 */
class Alert extends Component
{
    public $type;
    public $dismissible;
    public $message;
    public $attrs;

    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'alert';

    /**
     * @param string $type  Applies one of the Bootstrap theme color variants to the component
     * @param string $message  Show message alert to the component
     * @param string $class  Applies class name to the component
     * @param bool $dismissible  When set, enables the dismiss close button
     */
    public function __construct(
        $type = 'info',
        $message = '',
        $class = '',
        $dismissible = false
    )
    {
        $this->type = $type ?: '';
        $this->dismissible = $dismissible ?: false;
        $this->message = $message ?: '';
        $this->attrs = [
            'class' => $class ?: '',
        ];
        $this->attrs['class'] = Classes::get([
            $this->type ? 'alert alert-' . $this->type : '',
            $this->dismissible ? 'alert-dismissible fade show' : '',
            $this->attrs['class']
        ]);
        $this->attrs = \array_filter($this->attrs);
    }
}
