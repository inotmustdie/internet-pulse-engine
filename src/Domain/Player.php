<?php

declare(strict_types=1);

namespace NbaStatline\Domain;

final readonly class Player
{
    public function __construct(
        public string $id,
        public string $name,
        public string $teamCode,
        public string $position,
    ) {
        if ($id === '' || $name === '' || $teamCode === '') {
            throw new \InvalidArgumentException('Player id, name, and team are required.');
        }
    }
}
