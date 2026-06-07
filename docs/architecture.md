# Architecture

## Goal

The service models an NBA analytics backend with reviewable business logic and clear extension points.

It is intentionally standalone PHP instead of a full Laravel skeleton, because the goal is to make the important backend decisions easy to inspect:

- domain objects;
- provider abstraction;
- application services;
- metric calculator;
- deterministic tests;
- CLI/API-shaped JSON output.

## Boundaries

- `Domain`: `Team`, `Player`, `StatLine`, and `PlayerMetric`.
- `Infrastructure`: data providers, currently `LocalNbaStatsProvider`.
- `Analytics`: stat formulas and metric calculation.
- `Application`: leaderboard and team summary use cases.
- `Support`: response formatting.

## Data Provider Strategy

The project uses a provider interface:

```php
interface NbaStatsProvider
{
    public function teams(): array;
    public function players(): array;
    public function statLines(): array;
}
```

The local provider keeps CI deterministic. A production adapter could fetch from a paid sports data API, cache responses in Redis, and refresh data through scheduled jobs.

## Metrics

Supported metrics:

- `points`;
- `points-per-36`;
- `true-shooting`;
- `effective-fg`;
- `assist-turnover`;
- `usage-proxy`.

The formulas live in `MetricCalculator`, which keeps ranking logic separate from math details.

## Production Extension Plan

To turn this into a real Laravel service:

1. Wrap `LeaderboardService` and `TeamSummaryService` in controllers.
2. Add Redis cache tags per season/team/metric.
3. Add scheduled ingestion jobs.
4. Store provider snapshots in PostgreSQL.
5. Add OpenAPI docs and request validation.
6. Add rate limiting and auth for public API usage.
7. Add observability for ingestion freshness and provider failures.
