<?php

declare(strict_types=1);

namespace NbaStatline\Domain;

final readonly class PlayerMetric
{
    public function __construct(
        public Player $player,
        public Team $team,
        public StatLine $statLine,
        public string $metric,
        public float $value,
    ) {
    }

    /**
     * @return array<string, int|float|string>
     */
    public function toArray(): array
    {
        return [
            'player' => $this->player->name,
            'team' => $this->team->code,
            'position' => $this->player->position,
            'metric' => $this->metric,
            'value' => round($this->value, 1),
            'minutes' => $this->statLine->minutes,
        ];
    }
}
