<?php

namespace Sevenpluss\NewsCrud\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class RepositoryException
 * @package Sevenpluss\NewsCrud\Exceptions
 */
class RepositoryException extends HttpException
{
    /**
     * RepositoryException constructor.
     * @param string|null $message
     * @param \Exception|null $previous
     * @param int $code
     */
    public function __construct(string $message = null, \Exception $previous = null, int $code = 0)
    {
        parent::__construct(409, $message, $previous, [], $code);
    }
}
