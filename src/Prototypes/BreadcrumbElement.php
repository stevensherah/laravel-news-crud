<?php

namespace Sevenpluss\NewsCrud\Prototypes;

/**
 * Class BreadcrumbElement
 * @package Sevenpluss\NewsCrud\Prototypes
 */
class BreadcrumbElement extends AbstractPrototype
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string|null
     */
    public $url;

    /**
     * @var string|null
     */
    public $title;

    /**
     * BreadcrumbElement constructor.
     * @param string $name
     * @param null|string $url
     * @param null|string $title
     */
    public function __construct(string $name, string $url = null, string $title = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->title = $title;
    }
}
