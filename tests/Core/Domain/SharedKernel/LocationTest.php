<?php

declare(strict_types=1);

namespace App\Tests\Core\Domain\SharedKernel;

use Core\Domain\SharedKernel\Location;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    #[DoesNotPerformAssertions]
    public function testCorrectCreate(): void
    {
        $location = new Location(1, 1);
    }

    #[DataProvider('errorOnCreateDataProvider')]
    public function testValidationErrorCreate(int $x, int $y): void
    {
        $this->expectException(InvalidArgumentException::class);
        $location = new Location($x, $y);
    }

    public static function errorOnCreateDataProvider(): array
    {
        return [
            [-1, 4],
            [0, 4],
            [11, 4],
            [777, 4],
            [4, -1],
            [4, 0],
            [4, 11],
            [4, 777],
        ];
    }

    #[DataProvider('isEqualDataProvider')]
    public function testIsEqual(array $point1, array $point2, bool $expected): void
    {
        $location1 = new Location($point1['x'], $point1['y']);
        $location2 = new Location($point2['x'], $point2['y']);

        $this->assertEquals($expected, $location1->isEqual($location2));
    }

    public static function isEqualDataProvider(): array
    {
        return [
            [['x' => 1, 'y' => 2], ['x' => 3, 'y' => 4], false],
            [['x' => 1, 'y' => 2], ['x' => 1, 'y' => 4], false],
            [['x' => 1, 'y' => 2], ['x' => 3, 'y' => 2], false],
            [['x' => 1, 'y' => 2], ['x' => 1, 'y' => 2], true],
        ];
    }

    #[DataProvider('calculateDistanceDataProvider')]
    public function testCalculateDistance(array $point1, array $point2, int $expected): void
    {
        $location1 = new Location($point1['x'], $point1['y']);
        $location2 = new Location($point2['x'], $point2['y']);

        $this->assertEquals($expected, $location1->calculateDistance($location2));
    }

    public static function calculateDistanceDataProvider(): array
    {
        return [
            [['x' => 5, 'y' => 5], ['x' => 5, 'y' => 5], 0],
            [['x' => 5, 'y' => 5], ['x' => 5, 'y' => 6], 1],
            [['x' => 5, 'y' => 5], ['x' => 6, 'y' => 5], 1],
            [['x' => 5, 'y' => 5], ['x' => 5, 'y' => 4], 1],
            [['x' => 5, 'y' => 5], ['x' => 4, 'y' => 5], 1],
            [['x' => 5, 'y' => 5], ['x' => 6, 'y' => 6], 2],
            [['x' => 5, 'y' => 5], ['x' => 4, 'y' => 4], 2],
            [['x' => 5, 'y' => 5], ['x' => 8, 'y' => 1], 7],
        ];
    }
}
