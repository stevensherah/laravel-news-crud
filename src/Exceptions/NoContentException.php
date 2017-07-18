<?php

namespace Sevenpluss\NewsCrud\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class NoContentException
 * @package Sevenpluss\NewsCrud\Exceptions
 */
class NoContentException extends HttpException
{
    /**
     * NoContentException constructor.
     * @param null $message
     * @param \Exception|null $previous
     * @param int $code
     */
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct(204, $message, $previous, array(), $code);
    }
}
