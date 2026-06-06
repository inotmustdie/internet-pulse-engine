<?php

declare(strict_types=1);

namespace App\Infrastructure\Ai;

final class FakeAiRoutingProvider implements AiRoutingProvider
{
    public function summarizeRouting(string $service, ?string $comment): string
    {
        $context = $comment ? " Patient comment: {$comment}" : '';

        return "Route request to a specialist for {$service}.{$context}";
    }
}
