<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

/**
 * A card is a flexible and extensible content container. It includes options for headers and footers, a wide variety of content, contextual background colors, and powerful display options.
 */
class Card extends Component
{
    public $title;
    public $header;
    public $footer;
    public $noBody;
    public $bodyClass;
    public $attrs;
    public $prefix;
    public $imgSrc;
    public $imgTop;
    public $imgBottom;

    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'card';

    /**
     * @param string $title
     * @param string $header
     * @param string $footer
     * @param string $image
     * @param string $class
     * @param bool $noBody
     * @param string $bodyClass
     * @param string $imgSrc
     * @param bool $imgTop
     * @param bool $imgBottom
     */
    public function __construct(
        $title = '',
        $header = '',
        $footer = '',
        $image = '',
        $class = '',
        $noBody = false,
        $bodyClass = '',
        $imgSrc = '',
        $imgTop = true,
        $imgBottom = false
    )
    {
        $this->prefix = config('laka-core.prefix');
        $this->header = $header;
        $this->title = $title;
        $this->footer = $footer;
        $this->noBody = $noBody;
        $this->imgSrc = $imgSrc;
        $this->imgTop = $imgTop;
        $this->imgBottom = $imgBottom;
        $this->bodyClass = $bodyClass;
        $this->attrs = ['class' => Classes::get(['card', $class])];
    }
}
