<?php
declare(strict_types = 1);

namespace Jalismrs\Common\Exception\Entity;

use Jalismrs\Common\Exception\EntityException;
use Throwable;
use function vsprintf;

/**
 * Class NotFoundException
 *
 * @package Jalismrs\Common\Exception
 */
final class NotFoundException extends
    EntityException
{
    /**
     * NotFoundException constructor.
     *
     * @param string          $message
     * @param \Throwable|null $previous
     */
    public function __construct(
        $message = '',
        Throwable $previous = null
    ) {
        parent::__construct(
            $message,
            404,
            $previous
        );
    }

    /**
     * create
     *
     * @static
     *
     * @param string $class
     * @param string $identifier
     *
     * @return static
     */
    public static function create(
        string $class,
        string $identifier
    ) : self {
        $message = vsprintf(
            "Entity '%s'(%s) not found",
            [
                $class,
                $identifier,
            ]
        );

        return new self(
            $message
        );
    }
}
