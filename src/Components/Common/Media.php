<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

/**
 * The media object helps build complex and repetitive components where some media is positioned alongside content that doesn't wrap around said media.
 */
class Media extends Component
{
    public $attrs;
    public $attrs2;
    public $image;
    public $text;
    public $excerpt;
    public $body;
    public $tag;

    /**
     * @param string $class
     * @param array $image
     * @param array $excerpt
     * @param array $body
     * @param string $text
     * @param string $tag
     */
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
