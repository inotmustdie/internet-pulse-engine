<?php

declare(strict_types=1);

namespace InternetPulse\Domain;

final readonly class InfrastructureNode
{
    /**
     * @param list<string> $dependsOn
     */
    public function __construct(
        public string $id,
        public string $name,
        public InfrastructureLayer $layer,
        public int $impact,
        public int $redundancy,
        public int $blastRadius,
        public int $confidence,
        public array $dependsOn = [],
    ) {
        foreach (['impact' => $impact, 'redundancy' => $redundancy, 'blastRadius' => $blastRadius, 'confidence' => $confidence] as $field => $value) {
            if ($value < 1 || $value > 10) {
                throw new \InvalidArgumentException("{$field} must be between 1 and 10.");
            }
        }
    }
}
