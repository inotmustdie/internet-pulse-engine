# Architecture Notes

## Goal

Show a small but realistic backend flow where appointment creation, AI-assisted routing, and operator notifications do not collapse into one controller.

## Boundaries

The project uses three practical boundaries:

- `Domain`: appointment model and status language.
- `Application`: use cases that orchestrate business flow.
- `Infrastructure`: external systems such as AI providers and Telegram notifications.

This is intentionally lighter than full DDD. The goal is clarity, testability, and low change cost, not ceremony.

## External Integrations

AI and Telegram are represented through small adapters. In a production Laravel app these adapters would usually be bound in the service container and called from queued jobs.

The important decision is that the application use case does not depend on a concrete vendor SDK. That keeps the business flow stable if the project switches from OpenAI to Anthropic, adds retries, or introduces a fallback provider.

## Async Processing

For a production version, notification delivery should be dispatched to a queue:

- user-facing request creates the appointment;
- database transaction commits the state;
- job sends Telegram notification and optionally calls AI provider;
- failures are retried or sent to an operational alert path.

This avoids letting third-party latency define API latency.

## Testing Strategy

The included test focuses on behavior:

- appointment is created with the expected status;
- AI routing summary is prepared;
- notification payload is generated.

In a full Laravel application, the next useful tests would be:

- request validation feature tests;
- queue dispatch assertions;
- provider failure/retry tests;
- repository tests for persistence-specific behavior.
