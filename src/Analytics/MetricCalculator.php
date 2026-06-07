<?php

declare(strict_types=1);

namespace NbaStatline\Analytics;

use NbaStatline\Domain\StatLine;

final class MetricCalculator
{
    public function calculate(StatLine $line, string $metric): float
    {
        return match ($metric) {
            'points' => $line->points,
            'points-per-36' => $line->points / $line->minutes * 36,
            'true-shooting' => $this->trueShooting($line),
            'effective-fg' => $this->effectiveFieldGoal($line),
            'assist-turnover' => $line->turnovers === 0 ? $line->assists : $line->assists / $line->turnovers,
            'usage-proxy' => ($line->fieldGoalsAttempted + 0.44 * $line->freeThrowsAttempted + $line->turnovers) / $line->minutes * 36,
            default => throw new \InvalidArgumentException("Unsupported metric: {$metric}"),
        };
    }

    private function trueShooting(StatLine $line): float
    {
        $denominator = 2 * ($line->fieldGoalsAttempted + 0.44 * $line->freeThrowsAttempted);

        return $denominator <= 0 ? 0 : $line->points / $denominator * 100;
    }

    private function effectiveFieldGoal(StatLine $line): float
    {
        return $line->fieldGoalsAttempted <= 0
            ? 0
            : ($line->fieldGoalsMade + 0.5 * $line->threePointersMade) / $line->fieldGoalsAttempted * 100;
    }
}
