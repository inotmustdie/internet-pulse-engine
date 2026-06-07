<?php

declare(strict_types=1);

namespace Tests;

use NbaStatline\Analytics\MetricCalculator;
use NbaStatline\Application\LeaderboardService;
use NbaStatline\Infrastructure\LocalNbaStatsProvider;
use PHPUnit\Framework\TestCase;

final class LeaderboardServiceTest extends TestCase
{
    public function testItRanksPlayersByPoints(): void
    {
        $service = new LeaderboardService(new LocalNbaStatsProvider(), new MetricCalculator());

        $leaders = $service->leaders('points', 3);

        self::assertCount(3, $leaders);
        self::assertSame('Luka Doncic', $leaders[0]->player->name);
        self::assertSame(32.0, $leaders[0]->value);
    }

    public function testItCalculatesTrueShootingLeaderboard(): void
    {
        $service = new LeaderboardService(new LocalNbaStatsProvider(), new MetricCalculator());

        $leaders = $service->leaders('true-shooting', 1);

        self::assertSame('Nikola Jokic', $leaders[0]->player->name);
        self::assertGreaterThan(69, $leaders[0]->value);
    }
}
