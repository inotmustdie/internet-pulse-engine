# API Shape

The current CLI mirrors the intended HTTP API.

## Leaderboards

```http
GET /api/leaders?metric=true-shooting&limit=5
```

Response:

```json
{
  "metric": "true-shooting",
  "leaders": [
    {
      "player": "Nikola Jokic",
      "team": "DEN",
      "position": "C",
      "metric": "true-shooting",
      "value": 70.1,
      "minutes": 34.2
    }
  ]
}
```

## Team Summary

```http
GET /api/teams/DEN/summary
```

Response:

```json
{
  "team": "Denver Nuggets",
  "code": "DEN",
  "conference": "West",
  "pace": 97.8,
  "sample_players": 2,
  "points": 47,
  "assists": 16,
  "turnovers": 5,
  "assist_turnover_ratio": 3.2,
  "average_true_shooting": 65.5
}
```

## Export

```http
GET /api/export
```

Used by dashboards, bots, or small frontend widgets.
