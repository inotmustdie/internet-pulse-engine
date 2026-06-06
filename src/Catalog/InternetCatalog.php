<?php

declare(strict_types=1);

namespace InternetPulse\Catalog;

use InternetPulse\Domain\IncidentScenario;
use InternetPulse\Domain\InfrastructureLayer;
use InternetPulse\Domain\InfrastructureNode;

final class InternetCatalog
{
    /**
     * @return array<string, InfrastructureNode>
     */
    public function nodes(): array
    {
        $nodes = [
            new InfrastructureNode('dns-root', 'DNS root server system', InfrastructureLayer::NameResolution, 10, 8, 10, 9),
            new InfrastructureNode('recursive-dns', 'Public recursive resolvers', InfrastructureLayer::NameResolution, 8, 7, 8, 8, ['dns-root']),
            new InfrastructureNode('tld-registries', 'TLD registry infrastructure', InfrastructureLayer::NameResolution, 8, 6, 8, 8, ['dns-root']),
            new InfrastructureNode('tier1-transit', 'Tier-1 transit mesh', InfrastructureLayer::Routing, 10, 7, 10, 7),
            new InfrastructureNode('major-ixps', 'Major internet exchange points', InfrastructureLayer::Routing, 9, 6, 9, 7, ['tier1-transit']),
            new InfrastructureNode('submarine-cables', 'Submarine cable corridors', InfrastructureLayer::Physical, 9, 5, 9, 6),
            new InfrastructureNode('global-cdn', 'Global CDN and edge networks', InfrastructureLayer::EdgeDelivery, 8, 7, 8, 7, ['tier1-transit', 'major-ixps']),
            new InfrastructureNode('cloud-regions', 'Hyperscale cloud regions', InfrastructureLayer::Compute, 8, 6, 8, 8, ['tier1-transit', 'global-cdn']),
            new InfrastructureNode('certificate-authorities', 'Certificate authorities and OCSP', InfrastructureLayer::Trust, 7, 5, 7, 7, ['dns-root']),
            new InfrastructureNode('time-sync', 'NTP and time synchronization sources', InfrastructureLayer::Time, 6, 5, 6, 7),
        ];

        $indexed = [];
        foreach ($nodes as $node) {
            $indexed[$node->id] = $node;
        }

        return $indexed;
    }

    /**
     * @return array<string, IncidentScenario>
     */
    public function scenarios(): array
    {
        $scenarios = [
            new IncidentScenario(
                id: 'dns-root-degradation',
                title: 'DNS root degradation',
                summary: 'Root DNS degradation raises global lookup latency and increases dependency on recursive resolver cache behaviour.',
                affectedNodeIds: ['dns-root', 'recursive-dns', 'tld-registries'],
                degradation: 8,
            ),
            new IncidentScenario(
                id: 'cloud-region-loss',
                title: 'Major cloud region loss',
                summary: 'A hyperscale cloud region outage stresses failover assumptions, data replication, and edge routing.',
                affectedNodeIds: ['cloud-regions', 'global-cdn', 'tier1-transit'],
                degradation: 7,
            ),
            new IncidentScenario(
                id: 'transit-route-leak',
                title: 'Transit route leak',
                summary: 'A BGP route leak changes reachability and can redirect or blackhole traffic across unrelated services.',
                affectedNodeIds: ['tier1-transit', 'major-ixps', 'global-cdn'],
                degradation: 9,
            ),
            new IncidentScenario(
                id: 'certificate-validation-failure',
                title: 'Certificate validation failure',
                summary: 'Trust infrastructure degradation breaks TLS handshakes, API clients, package downloads, and automated deploys.',
                affectedNodeIds: ['certificate-authorities', 'dns-root', 'time-sync'],
                degradation: 7,
            ),
        ];

        $indexed = [];
        foreach ($scenarios as $scenario) {
            $indexed[$scenario->id] = $scenario;
        }

        return $indexed;
    }
}
