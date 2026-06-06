<?php

declare(strict_types=1);

namespace InternetPulse\Domain;

final readonly class RiskAssessment
{
    /**
     * @param list<string> $mostAffectedLayers
     * @param list<string> $reasons
     * @param list<string> $recommendedActions
     */
    public function __construct(
        public string $scenarioId,
        public int $riskScore,
        public string $severity,
        public array $mostAffectedLayers,
        public string $summary,
        public array $reasons,
        public array $recommendedActions,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'scenario' => $this->scenarioId,
            'risk_score' => $this->riskScore,
            'severity' => $this->severity,
            'most_affected_layers' => $this->mostAffectedLayers,
            'summary' => $this->summary,
            'reasons' => $this->reasons,
            'recommended_actions' => $this->recommendedActions,
        ];
    }
}
