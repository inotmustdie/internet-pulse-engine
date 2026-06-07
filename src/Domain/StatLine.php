<?php

declare(strict_types=1);

namespace NbaStatline\Domain;

final readonly class StatLine
{
    public function __construct(
        public string $playerId,
        public float $minutes,
        public int $points,
        public int $fieldGoalsMade,
        public int $fieldGoalsAttempted,
        public int $threePointersMade,
        public int $freeThrowsAttempted,
        public int $rebounds,
        public int $assists,
        public int $turnovers,
    ) {
        if ($minutes <= 0) {
            throw new \InvalidArgumentException('Minutes must be greater than zero.');
        }
    }
}
