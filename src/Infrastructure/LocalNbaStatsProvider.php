<?php

declare(strict_types=1);

namespace NbaStatline\Infrastructure;

use NbaStatline\Domain\Player;
use NbaStatline\Domain\StatLine;
use NbaStatline\Domain\Team;

final class LocalNbaStatsProvider implements NbaStatsProvider
{
    public function teams(): array
    {
        return [
            'DEN' => new Team('DEN', 'Denver Nuggets', 'West', 97.8),
            'BOS' => new Team('BOS', 'Boston Celtics', 'East', 99.2),
            'DAL' => new Team('DAL', 'Dallas Mavericks', 'West', 98.6),
            'MIL' => new Team('MIL', 'Milwaukee Bucks', 'East', 101.1),
            'OKC' => new Team('OKC', 'Oklahoma City Thunder', 'West', 100.4),
        ];
    }

    public function players(): array
    {
        return [
            'jokic' => new Player('jokic', 'Nikola Jokic', 'DEN', 'C'),
            'murray' => new Player('murray', 'Jamal Murray', 'DEN', 'G'),
            'tatum' => new Player('tatum', 'Jayson Tatum', 'BOS', 'F'),
            'brown' => new Player('brown', 'Jaylen Brown', 'BOS', 'F'),
            'doncic' => new Player('doncic', 'Luka Doncic', 'DAL', 'G'),
            'giannis' => new Player('giannis', 'Giannis Antetokounmpo', 'MIL', 'F'),
            'shai' => new Player('shai', 'Shai Gilgeous-Alexander', 'OKC', 'G'),
        ];
    }

    public function statLines(): array
    {
        return [
            new StatLine('jokic', 34.2, 26, 10, 15, 1, 6, 12, 9, 3),
            new StatLine('murray', 32.1, 21, 8, 17, 3, 3, 4, 7, 2),
            new StatLine('tatum', 35.8, 27, 9, 20, 4, 6, 8, 5, 3),
            new StatLine('brown', 33.4, 23, 9, 18, 2, 4, 6, 3, 2),
            new StatLine('doncic', 37.5, 32, 11, 23, 4, 8, 9, 10, 4),
            new StatLine('giannis', 34.8, 30, 12, 19, 0, 10, 11, 6, 4),
            new StatLine('shai', 35.1, 31, 11, 21, 2, 9, 6, 7, 2),
        ];
    }
}
