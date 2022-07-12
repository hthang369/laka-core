<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

/**
 * Push notifications to your visitors with a toast, a lightweight and easily customizable alert message.
 */
class Toasts extends Component
{
    public $type;
    public $dismissible;
    public $message;
    public $title;
    public $attrs;
    public $headerClass;

    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'alert';

    /**
     * @param string $type
     * @param string $title
     * @param string $message
     * @param string $class
     * @param string $variant
     * @param bool $dismissible
     * @param int $delay
     */
    public function __construct(
        $type = '',
        $title = '',
        $message = '',
        $class = '',
        $variant = '',
        $dismissible = true,
        $delay = 0
    )
    {
        $this->type = $type ?: '';
        $this->title = $title ?: '';
        $this->dismissible = $dismissible ?: true;
        $this->message = $message ?: '';
        $this->attrs = [
            'class' => $class ?: '',
            'role' => 'alert',
            'aria-live' => 'assertive',
            'aria-atomic' => 'true',
        ];
        if ($delay > 0) {
            $this->attrs['data-delay'] = $delay;
        }
        $this->attrs['class'] = Classes::get([
            'toast',
            $this->attrs['class']
        ]);
        if (!blank($variant)) {
            $this->headerClass = Classes::get([
                "bg-{$variant}",
                'text-light'
            ]);
        }
        $this->attrs = \array_filter($this->attrs);
    }
}
