<?php

namespace Sevenpluss\NewsCrud\Prototypes;

/**
 * Class Message
 * @package Sevenpluss\NewsCrud\Prototypes
 */
class Message extends AbstractPrototype
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $text;

    /**
     * Message constructor.
     * @param string $text
     * @param string $type
     */
    public function __construct(string $text, string $type = 'success')
    {
        $this->text = $text;
        $this->type = $type;
    }
}
