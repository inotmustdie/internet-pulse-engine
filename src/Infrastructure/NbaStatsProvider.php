<?php

declare(strict_types=1);

namespace NbaStatline\Infrastructure;

use NbaStatline\Domain\Player;
use NbaStatline\Domain\StatLine;
use NbaStatline\Domain\Team;

interface NbaStatsProvider
{
    /** @return array<string, Team> */
    public function teams(): array;

    /** @return array<string, Player> */
    public function players(): array;

    /** @return list<StatLine> */
    public function statLines(): array;
}
