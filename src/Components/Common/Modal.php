<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

/**
 * Modals are streamlined, but flexible dialog prompts powered by JavaScript and CSS. They support a number of use cases from user notification to completely custom content and feature a handful of helpful sub-components, sizes, variants, accessibility, and more.
 */
class Modal extends Component
{
    public $childs;
    public $attrs;
    public $title;
    public $body;
    public $footer;
    public $dialog;

    /**
     * @param string $title
     * @param string $body
     * @param string $footer
     * @param string $class
     * @param bool $scrollable
     * @param bool $centered
     * @param string $size
     * @param string $id
     */
    public function __construct(
        $title = '',
        $body = '',
        $footer = '',
        $class = '',
        $scrollable = false,
        $centered = false,
        $size = '',
        $id = ''
    )
    {
        $this->title = $title ?? '';
        $this->body = $body ?? '';
        $this->footer = $footer ?? '';
        $this->scrollable = $scrollable ?? false;
        $this->centered = $centered ?? false;
        $this->size = $size ?? '';
        $this->attrs = [
            'id' => $id ?? '',
        ];
        $this->attrs['class'] = Classes::get([
            'modal',
            'class' => $class ?? 'fade',
        ]);
        $this->dialog['class'] = Classes::get([
            'modal-dialog',
            $this->scrollable === true ? 'modal-dialog-scrollable' : '',
            $this->centered === true ? 'modal-dialog-centered' : '',
            !empty($this->size) ? 'modal-' . $this->size : '',
        ]);
        $this->attrs = \array_filter($this->attrs);
    }
}
