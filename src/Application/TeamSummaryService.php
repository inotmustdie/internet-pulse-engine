<?php

declare(strict_types=1);

namespace NbaStatline\Application;

use NbaStatline\Analytics\MetricCalculator;
use NbaStatline\Infrastructure\NbaStatsProvider;

final readonly class TeamSummaryService
{
    public function __construct(
        private NbaStatsProvider $provider,
        private MetricCalculator $calculator,
    ) {
    }

    /**
     * @return array<string, float|int|string>
     */
    public function summary(string $teamCode): array
    {
        $teams = $this->provider->teams();
        if (! isset($teams[$teamCode])) {
            throw new \InvalidArgumentException("Unknown team: {$teamCode}");
        }

        $players = array_filter(
            $this->provider->players(),
            static fn ($player): bool => $player->teamCode === $teamCode,
        );

        $lines = array_filter(
            $this->provider->statLines(),
            static fn ($line): bool => isset($players[$line->playerId]),
        );

        $totalPoints = array_sum(array_map(static fn ($line): int => $line->points, $lines));
        $totalAssists = array_sum(array_map(static fn ($line): int => $line->assists, $lines));
        $totalTurnovers = array_sum(array_map(static fn ($line): int => $line->turnovers, $lines));

        $trueShootingValues = array_map(
            fn ($line): float => $this->calculator->calculate($line, 'true-shooting'),
            $lines,
        );

        return [
            'team' => $teams[$teamCode]->name,
            'code' => $teamCode,
            'conference' => $teams[$teamCode]->conference,
            'pace' => $teams[$teamCode]->pace,
            'sample_players' => count($players),
            'points' => $totalPoints,
            'assists' => $totalAssists,
            'turnovers' => $totalTurnovers,
            'assist_turnover_ratio' => $totalTurnovers === 0 ? $totalAssists : round($totalAssists / $totalTurnovers, 2),
            'average_true_shooting' => count($trueShootingValues) === 0 ? 0 : round(array_sum($trueShootingValues) / count($trueShootingValues), 1),
        ];
    }
}
