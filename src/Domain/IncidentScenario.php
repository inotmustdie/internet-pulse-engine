<?php

declare(strict_types=1);

namespace InternetPulse\Domain;

final readonly class IncidentScenario
{
    /**
     * @param list<string> $affectedNodeIds
     */
    public function __construct(
        public string $id,
        public string $title,
        public string $summary,
        public array $affectedNodeIds,
        public int $degradation,
    ) {
        if ($degradation < 1 || $degradation > 10) {
            throw new \InvalidArgumentException('Degradation must be between 1 and 10.');
        }
    }
}
