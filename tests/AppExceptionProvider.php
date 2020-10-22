<?php
declare(strict_types = 1);

namespace Tests;

use Exception;

/**
 * Class AppExceptionProvider
 *
 * @package Tests
 */
final class AppExceptionProvider
{
    /**
     * provideConstructor
     *
     * @return array|\array[][]
     */
    public function provideConstructor() : array
    {
        $previous = new Exception(
            'test'
        );

        return [
            'default'                      => [
                'input'  => [
                    'message'  => '',
                    'code'     => 0,
                    'previous' => null,
                ],
                'output' => [
                    'message'  => '',
                    'code'     => 0,
                    'previous' => null,
                ],
            ],
            'with message'                 => [
                'input'  => [
                    'message'  => 'message',
                    'code'     => 0,
                    'previous' => null,
                ],
                'output' => [
                    'message'  => 'message',
                    'code'     => 0,
                    'previous' => null,
                ],
            ],
            'with code integer'            => [
                'input'  => [
                    'message'  => '',
                    'code'     => 42,
                    'previous' => null,
                ],
                'output' => [
                    'message'  => '',
                    'code'     => 42,
                    'previous' => null,
                ],
            ],
            'with code float'              => [
                'input'  => [
                    'message'  => '',
                    'code'     => 42.51,
                    'previous' => null,
                ],
                'output' => [
                    'message'  => '',
                    'code'     => 42,
                    'previous' => null,
                ],
            ],
            'with code string numeric'     => [
                'input'  => [
                    'message'  => '',
                    'code'     => '42',
                    'previous' => null,
                ],
                'output' => [
                    'message'  => '',
                    'code'     => 42,
                    'previous' => null,
                ],
            ],
            'with code string not numeric' => [
                'input'  => [
                    'message'  => '',
                    'code'     => 'code',
                    'previous' => null,
                ],
                'output' => [
                    'message'  => '',
                    'code'     => 0,
                    'previous' => null,
                ],
            ],
            'with previous'                => [
                'input'  => [
                    'message'  => '',
                    'code'     => 0,
                    'previous' => $previous,
                ],
                'output' => [
                    'message'  => '',
                    'code'     => 0,
                    'previous' => $previous,
                ],
            ],
        ];
    }
}
