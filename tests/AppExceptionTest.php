<?php
declare(strict_types = 1);

namespace Tests;

use Jalismrs\ExceptionBundle\AppException;
use PHPUnit\Framework\TestCase;

/**
 * Class AppExceptionTest
 *
 * @package Tests
 *
 * @covers  \Jalismrs\ExceptionBundle\AppException
 */
final class AppExceptionTest extends
    TestCase
{
    /**
     * testAppException
     *
     * @param array $providedInput
     * @param array $providedOutput
     *
     * @return void
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     *
     * @dataProvider \Tests\AppExceptionProvider::provideConstructor
     */
    public function testAppException(
        array $providedInput,
        array $providedOutput
    ) : void {
        // act
        $output = new AppException(
            $providedInput['message'],
            $providedInput['code'],
            $providedInput['previous']
        );

        // assert
        self::assertSame(
            $providedOutput['message'],
            $output->getMessage()
        );
        self::assertSame(
            $providedOutput['code'],
            $output->getCode()
        );
        self::assertSame(
            $providedOutput['previous'],
            $output->getPrevious()
        );
    }
}
