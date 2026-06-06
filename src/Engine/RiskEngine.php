<?php

declare(strict_types=1);

namespace InternetPulse\Engine;

use InternetPulse\Domain\IncidentScenario;
use InternetPulse\Domain\InfrastructureLayer;
use InternetPulse\Domain\InfrastructureNode;
use InternetPulse\Domain\RiskAssessment;

final class RiskEngine
{
    /**
     * @param array<string, InfrastructureNode> $nodes
     */
    public function assess(IncidentScenario $scenario, array $nodes): RiskAssessment
    {
        $affected = $this->affectedNodes($scenario, $nodes);
        $layerWeights = [];
        $reasons = [];

        $rawScore = 0.0;
        foreach ($affected as $node) {
            $nodeRisk = $this->nodeRisk($node, $scenario->degradation);
            $rawScore += $nodeRisk;
            $layerWeights[$node->layer->value] = ($layerWeights[$node->layer->value] ?? 0) + $nodeRisk;

            $reasons[] = sprintf(
                '%s has impact %d/10, redundancy %d/10, blast radius %d/10.',
                $node->name,
                $node->impact,
                $node->redundancy,
                $node->blastRadius,
            );
        }

        arsort($layerWeights);
        $riskScore = min(100, (int) round($rawScore / max(1, count($affected)) * 12));

        return new RiskAssessment(
            scenarioId: $scenario->id,
            riskScore: $riskScore,
            severity: $this->severity($riskScore),
            mostAffectedLayers: array_slice(array_keys($layerWeights), 0, 3),
            summary: $scenario->summary,
            reasons: $reasons,
            recommendedActions: $this->recommendations(array_keys($layerWeights)),
        );
    }

    /**
     * @param array<string, InfrastructureNode> $nodes
     * @return list<InfrastructureNode>
     */
    private function affectedNodes(IncidentScenario $scenario, array $nodes): array
    {
        $affected = [];
        foreach ($scenario->affectedNodeIds as $id) {
            if (! isset($nodes[$id])) {
                throw new \InvalidArgumentException("Unknown infrastructure node: {$id}");
            }

            $affected[] = $nodes[$id];
        }

        return $affected;
    }

    private function nodeRisk(InfrastructureNode $node, int $degradation): float
    {
        $redundancyPenalty = 11 - $node->redundancy;

        return (
            $node->impact * 0.34
            + $node->blastRadius * 0.28
            + $redundancyPenalty * 0.22
            + $degradation * 0.16
        ) * ($node->confidence / 10);
    }

    private function severity(int $riskScore): string
    {
        return match (true) {
            $riskScore >= 80 => 'critical',
            $riskScore >= 65 => 'high',
            $riskScore >= 40 => 'medium',
            default => 'low',
        };
    }

    /**
     * @param list<string> $layers
     * @return list<string>
     */
    private function recommendations(array $layers): array
    {
        $map = [
            InfrastructureLayer::NameResolution->value => 'verify authoritative DNS redundancy and recursive resolver failover',
            InfrastructureLayer::Routing->value => 'monitor BGP announcements, route leaks, and transit failover paths',
            InfrastructureLayer::EdgeDelivery->value => 'check CDN origin shielding, cache hit rate, and bypass behaviour',
            InfrastructureLayer::Compute->value => 'validate multi-region failover, replication lag, and rollback paths',
            InfrastructureLayer::Trust->value => 'check certificate renewal, OCSP stapling, and CA fallback assumptions',
            InfrastructureLayer::Time->value => 'verify NTP source diversity and clock drift alerting',
            InfrastructureLayer::Physical->value => 'review cable corridor concentration and regional traffic rerouting',
        ];

        $actions = [];
        foreach ($layers as $layer) {
            if (isset($map[$layer])) {
                $actions[] = $map[$layer];
            }
        }

        return array_values(array_unique($actions));
    }
}
