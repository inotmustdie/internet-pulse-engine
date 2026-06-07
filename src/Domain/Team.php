<?php

declare(strict_types=1);

namespace NbaStatline\Domain;

final readonly class Team
{
    public function __construct(
        public string $code,
        public string $name,
        public string $conference,
        public float $pace,
    ) {
        if ($code === '' || $name === '') {
            throw new \InvalidArgumentException('Team code and name are required.');
        }
    }
}
