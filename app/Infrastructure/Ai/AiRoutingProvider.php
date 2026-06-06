<?php

declare(strict_types=1);

namespace App\Infrastructure\Ai;

interface AiRoutingProvider
{
    public function summarizeRouting(string $service, ?string $comment): string;
}
