<?php

declare(strict_types=1);

use InternetPulse\Catalog\InternetCatalog;
use InternetPulse\Engine\RiskEngine;

it('classifies DNS root degradation as a critical or high risk scenario', function (): void {
    $catalog = new InternetCatalog();
    $assessment = (new RiskEngine())->assess(
        $catalog->scenarios()['dns-root-degradation'],
        $catalog->nodes(),
    );

    expect($assessment->riskScore)->toBeGreaterThanOrEqual(65);
    expect($assessment->mostAffectedLayers)->toContain('name-resolution');
    expect($assessment->recommendedActions)->not->toBeEmpty();
});

it('returns explainable reasons for affected infrastructure nodes', function (): void {
    $catalog = new InternetCatalog();
    $assessment = (new RiskEngine())->assess(
        $catalog->scenarios()['transit-route-leak'],
        $catalog->nodes(),
    );

    expect($assessment->reasons)->toHaveCount(3);
    expect($assessment->toArray())->toHaveKeys([
        'scenario',
        'risk_score',
        'severity',
        'most_affected_layers',
        'summary',
        'reasons',
        'recommended_actions',
    ]);
});
