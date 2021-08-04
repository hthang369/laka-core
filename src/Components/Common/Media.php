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
    public $headline;

    public function __construct(
        $class = '',
        $image = [],
        $excerpt = [],
        $body = [],
        $text = '',
        $headline = []
    ) {
        $this->all = $all ?? [];
        $this->excerpt = $excerpt ?? [];
        $this->headline = $headline ?? [];
        $this->image = $image ?? [];
        $this->body = $body ?? [];
        $this->text = $text ?? '';
        $this->attrs2 = attributes_get($all ?? [], [
            'class', 'body', 'text', 'image', 'headline'
        ]);
        $this->attrs['class'] = Classes::get([
            'media',
            'class' => $class ?? '',
        ]);
        $this->headline['class'] = Classes::get([
            'media-title',
            $this->headline['class'] ?? '',
        ]);
        $this->body['class'] = Classes::get([
            'media-body',
            $this->body['class'] ?? '',
        ]);
        $this->body['attrs'] = attributes_get($this->body);
        $this->attrs = \array_filter($this->attrs);

        $merge = ['image', 'headline', 'excerpt'];
        foreach($merge as $item) {
            $this->$item = \array_replace_recursive (
                $all[$item] ?? [],
                $this->$item ?? []
            );
        }

        if (isset($this->excerpt['show']) && isset($this->excerpt['text'])) {
            $this->text = $this->excerpt['text'];
        }
    }
}
