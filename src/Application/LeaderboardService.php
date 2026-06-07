<?php

declare(strict_types=1);

namespace NbaStatline\Application;

use NbaStatline\Analytics\MetricCalculator;
use NbaStatline\Domain\PlayerMetric;
use NbaStatline\Infrastructure\NbaStatsProvider;

final readonly class LeaderboardService
{
    public function __construct(
        private NbaStatsProvider $provider,
        private MetricCalculator $calculator,
    ) {
    }

    /**
     * @return list<PlayerMetric>
     */
    public function leaders(string $metric, int $limit = 5): array
    {
        $players = $this->provider->players();
        $teams = $this->provider->teams();
        $metrics = [];

        foreach ($this->provider->statLines() as $line) {
            $player = $players[$line->playerId] ?? null;
            if ($player === null) {
                continue;
            }

            $team = $teams[$player->teamCode];
            $metrics[] = new PlayerMetric(
                player: $player,
                team: $team,
                statLine: $line,
                metric: $metric,
                value: $this->calculator->calculate($line, $metric),
            );
        }

        usort($metrics, static fn (PlayerMetric $a, PlayerMetric $b): int => $b->value <=> $a->value);

        return array_slice($metrics, 0, $limit);
    }
}
