<?php

declare(strict_types=1);

namespace Core\Domain\SharedKernel;

use InvalidArgumentException;

readonly class Location
{
    public int $x;
    public int $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $this->validate($x)
            ? $x
            : throw new InvalidArgumentException("Argument $x must be a valid number");
        $this->y = $this->validate($y)
            ? $y
            : throw new InvalidArgumentException("Argument $y must be a valid number");
    }

    private function validate(int $value): bool
    {
        return 0 < $value && 11 > $value;
    }

    public function isEqual(Location $another): bool
    {
        return $this->x === $another->x && $this->y === $another->y;
    }

    public function calculateDistance(Location $another): int
    {
        return abs($this->x - $another->x) + abs($this->y - $another->y);
    }
}
