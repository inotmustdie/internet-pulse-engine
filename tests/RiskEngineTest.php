<?php

declare(strict_types=1);

namespace Tests;

use InternetPulse\Catalog\InternetCatalog;
use InternetPulse\Engine\RiskEngine;
use PHPUnit\Framework\TestCase;

final class RiskEngineTest extends TestCase
{
    public function testDnsRootDegradationIsCriticalOrHighRisk(): void
    {
        $catalog = new InternetCatalog();
        $assessment = (new RiskEngine())->assess(
            $catalog->scenarios()['dns-root-degradation'],
            $catalog->nodes(),
        );

        self::assertGreaterThanOrEqual(65, $assessment->riskScore);
        self::assertContains('name-resolution', $assessment->mostAffectedLayers);
        self::assertNotEmpty($assessment->recommendedActions);
    }

    public function testRiskAssessmentReturnsExplainableReasons(): void
    {
        $catalog = new InternetCatalog();
        $assessment = (new RiskEngine())->assess(
            $catalog->scenarios()['transit-route-leak'],
            $catalog->nodes(),
        );

        $payload = $assessment->toArray();

        self::assertCount(3, $assessment->reasons);
        self::assertArrayHasKey('scenario', $payload);
        self::assertArrayHasKey('risk_score', $payload);
        self::assertArrayHasKey('severity', $payload);
        self::assertArrayHasKey('most_affected_layers', $payload);
        self::assertArrayHasKey('summary', $payload);
        self::assertArrayHasKey('reasons', $payload);
        self::assertArrayHasKey('recommended_actions', $payload);
    }
}
