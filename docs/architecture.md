# Architecture Notes

## Goal

The project models global internet dependency risk in a way that is reviewable, deterministic, and easy to explain.

It deliberately avoids real-time scraping in the core engine. Live telemetry can be added later as an ingestion layer, but the scoring model should remain testable without the network.

## Boundaries

- `Catalog`: curated infrastructure nodes and scenarios.
- `Domain`: immutable concepts such as nodes, layers, scenarios, and assessments.
- `Engine`: deterministic scoring logic.
- `Support`: output helpers and integration-friendly formatting.

## Scoring Model

Each infrastructure node carries:

- impact;
- redundancy;
- blast radius;
- confidence;
- dependency links.

The engine combines these with scenario degradation. Redundancy is inverted, because low redundancy increases risk.

The model is approximate by design. The important property is not perfect prediction; it is explainability and consistent comparison between scenarios.

## Production Extensions

A production version could add:

- telemetry ingestion from DNS, BGP, CDN, cloud, and certificate monitoring sources;
- Redis-backed scenario cache;
- scheduled risk recomputation;
- OpenTelemetry traces for ingestion jobs;
- webhooks for incident notifications;
- API endpoints for dashboards and internal tooling.

## Senior-Level Signals

This project is meant to show:

- domain modelling without overengineering;
- clear architectural boundaries;
- deterministic business logic;
- explainable risk output;
- tests around critical behaviour;
- awareness of external-system failure modes.
