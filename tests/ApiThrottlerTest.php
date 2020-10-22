<?php
declare(strict_types = 1);

namespace Tests;

use Jalismrs\ExceptionBundle\Exception;
use Maba\GentleForce\Exception\RateLimitReachedException;
use Maba\GentleForce\RateLimitProvider;
use Maba\GentleForce\ThrottlerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

/**
 * Class ExceptionTest
 *
 * @package Tests
 *
 * @covers  \Jalismrs\ExceptionBundle\Exception
 */
final class ExceptionTest extends
    TestCase
{
    /**
     * mockRateLimitProvider
     *
     * @var \Maba\GentleForce\RateLimitProvider|\PHPUnit\Framework\MockObject\MockObject
     */
    private MockObject $mockRateLimitProvider;
    /**
     * mockThrottler
     *
     * @var \Maba\GentleForce\ThrottlerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private MockObject $mockThrottler;
    
    /**
     * testRegisterRateLimits
     *
     * @return void
     *
     * @throws \PHPUnit\Framework\MockObject\RuntimeException
     */
    public function testRegisterRateLimits() : void
    {
        // arrange
        $systemUnderTest = $this->createSUT();
        
        $rateLimits = [];
        
        // expect
        $this->mockRateLimitProvider
            ->expects(self::once())
            ->method('registerRateLimits')
            ->with(
                self::equalTo(ExceptionProvider::USE_CASE_KEY),
                self::equalTo($rateLimits)
            );
        
        // act
        $systemUnderTest->registerRateLimits(
            ExceptionProvider::USE_CASE_KEY,
            $rateLimits
        );
    }
    
    /**
     * createSUT
     *
     * @return \Jalismrs\ExceptionBundle\Exception
     */
    private function createSUT() : Exception
    {
        return new Exception(
            $this->mockRateLimitProvider,
            $this->mockThrottler,
        );
    }
    
    /**
     * testWaitAndIncrease
     *
     * @return void
     *
     * @throws \PHPUnit\Framework\MockObject\RuntimeException
     * @throws \Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException
     */
    public function testWaitAndIncrease() : void
    {
        // arrange
        $systemUnderTest = $this->createSUT();
        
        // expect
        $this->mockThrottler
            ->expects(self::exactly(2))
            ->method('checkAndIncrease')
            ->with(
                self::equalTo(ExceptionProvider::USE_CASE_KEY),
                self::equalTo(ExceptionProvider::IDENTIFIER)
            )
            ->willReturnOnConsecutiveCalls(
                self::throwException(
                    new RateLimitReachedException(
                        42,
                        'Rate limit was reached'
                    )
                ),
                null
            );
        
        // act
        $systemUnderTest->waitAndIncrease(
            ExceptionProvider::USE_CASE_KEY,
            ExceptionProvider::IDENTIFIER
        );
    }
    
    /**
     * testWaitAndIncreaseThrowsRateLimitReachedException
     *
     * @return void
     *
     * @throws \PHPUnit\Framework\MockObject\RuntimeException
     * @throws \Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException
     */
    public function testWaitAndIncreaseThrowsRateLimitReachedException() : void
    {
        // arrange
        $systemUnderTest = $this->createSUT();
        
        // expect
        $this->expectException(TooManyRequestsHttpException::class);
        $this->expectExceptionMessage('Loop limit was reached');
        $this->mockThrottler
            ->expects(self::once())
            ->method('checkAndIncrease')
            ->with(
                self::equalTo(ExceptionProvider::USE_CASE_KEY),
                self::equalTo(ExceptionProvider::IDENTIFIER)
            )
            ->willThrowException(
                new RateLimitReachedException(
                    42,
                    'Rate limit was reached'
                )
            );
        
        // act
        $systemUnderTest->setCap(1);
        $systemUnderTest->waitAndIncrease(
            ExceptionProvider::USE_CASE_KEY,
            ExceptionProvider::IDENTIFIER
        );
    }
    
    /**
     * testDecrease
     *
     * @return void
     *
     * @throws \PHPUnit\Framework\MockObject\RuntimeException
     */
    public function testDecrease() : void
    {
        // arrange
        $systemUnderTest = $this->createSUT();
        
        // expect
        $this->mockThrottler
            ->expects(self::once())
            ->method('decrease')
            ->with(
                self::equalTo(ExceptionProvider::USE_CASE_KEY),
                self::equalTo(ExceptionProvider::IDENTIFIER)
            );
        
        // act
        $systemUnderTest->decrease(
            ExceptionProvider::USE_CASE_KEY,
            ExceptionProvider::IDENTIFIER
        );
    }
    
    /**
     * testReset
     *
     * @return void
     *
     * @throws \PHPUnit\Framework\MockObject\RuntimeException
     */
    public function testReset() : void
    {
        // arrange
        $systemUnderTest = $this->createSUT();
        
        // expect
        $this->mockThrottler
            ->expects(self::once())
            ->method('reset')
            ->with(
                self::equalTo(ExceptionProvider::USE_CASE_KEY),
                self::equalTo(ExceptionProvider::IDENTIFIER)
            );
        
        // act
        $systemUnderTest->reset(
            ExceptionProvider::USE_CASE_KEY,
            ExceptionProvider::IDENTIFIER
        );
    }
    
    /**
     * setUp
     *
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();
        
        $this->mockRateLimitProvider = $this->createMock(RateLimitProvider::class);
        $this->mockThrottler         = $this->createMock(ThrottlerInterface::class);
    }
}
