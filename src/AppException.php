<?php
declare(strict_types = 1);

namespace Jalismrs\ExceptionBundle;

use RuntimeException;
use Throwable;
use function is_numeric;

/**
 * Class AppException
 *
 * @package Jalismrs\ExceptionBundle
 */
class AppException extends
    RuntimeException implements
    ExceptionInterface
{
    /**
     * AppException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct(
        $message = '',
        $code = 0,
        Throwable $previous = null
    ) {
        $code = is_numeric($code)
            ? (int)$code
            : 0;
    
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }
}
