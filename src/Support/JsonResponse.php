<?php

declare(strict_types=1);

namespace InternetPulse\Support;

final class JsonResponse
{
    /**
     * @param array<string, mixed> $payload
     */
    public static function encode(array $payload): string
    {
        return json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
    }
}
