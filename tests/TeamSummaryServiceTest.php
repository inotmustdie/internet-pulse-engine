<?php

declare(strict_types=1);

namespace Tests;

use NbaStatline\Analytics\MetricCalculator;
use NbaStatline\Application\TeamSummaryService;
use NbaStatline\Infrastructure\LocalNbaStatsProvider;
use PHPUnit\Framework\TestCase;

final class TeamSummaryServiceTest extends TestCase
{
    public function testItBuildsTeamSummary(): void
    {
        $service = new TeamSummaryService(new LocalNbaStatsProvider(), new MetricCalculator());

        $summary = $service->summary('DEN');

        self::assertSame('Denver Nuggets', $summary['team']);
        self::assertSame(47, $summary['points']);
        self::assertSame(16, $summary['assists']);
        self::assertSame(5, $summary['turnovers']);
        self::assertSame(3.2, $summary['assist_turnover_ratio']);
    }
}
