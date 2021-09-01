<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

class Media extends Component
{
    public $attrs;
    public $attrs2;
    public $image;
    public $text;
    public $excerpt;
    public $body;
    public $tag;

    public function __construct(
        $class = '',
        $image = [],
        $excerpt = [],
        $body = [],
        $text = '',
        $tag = ''
    ) {
        $this->excerpt = $excerpt ?? [];
        $this->image = $image ?? [];
        $this->body = $body ?? [];
        $this->text = $text ?? '';
        $this->tag = $tag ?? 'div';
        $this->attrs['class'] = Classes::get([
            'media',
            'class' => $class ?? '',
        ]);
        $this->body['class'] = Classes::get([
            'media-body',
            $this->body['class'] ?? '',
        ]);
        $this->body['attrs'] = attributes_get($this->body);
        $this->attrs = \array_filter($this->attrs);

        if (isset($this->excerpt['show']) && isset($this->excerpt['text'])) {
            $this->text = $this->excerpt['text'];
        }
    }
}
