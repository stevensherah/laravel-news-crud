<?php

namespace Sevenpluss\NewsCrud\Prototypes;

/**
 * Class Image
 * @package Sevenpluss\NewsCrud\Prototypes
 */
class Image extends AbstractPrototype
{
    /**
     * @var string
     */
    public $slug;

    /**
     * @var string|null
     */
    public $url;

    /**
     * @var int|null
     */
    public $width;

    /**
     * @var int|null
     */
    public $height;

    /**
     * @var string|null
     */
    public $mime;

    /**
     * @var string|null
     */
    public $mimetypes;

    /**
     * Image constructor.
     * @param string $slug
     * @param string $url
     * @param int|null $width
     * @param int|null $height
     * @param string|null $mime
     * @param string|null $mimetypes
     */
    public function __construct(
        string $slug,
        string $url,
        int $width = null,
        int $height = null,
        string $mime = null,
        string $mimetypes = null
    ) {
        $this->slug = $slug;
        $this->url = $url;
        $this->width = $width;
        $this->height = $height;
        $this->mime = $mime;
        $this->mimetypes = $mimetypes;
    }
}
