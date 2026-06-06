<?php

declare(strict_types=1);

namespace InternetPulse\Domain;

enum InfrastructureLayer: string
{
    case NameResolution = 'name-resolution';
    case Routing = 'routing';
    case EdgeDelivery = 'edge-delivery';
    case Compute = 'compute';
    case Trust = 'trust';
    case Time = 'time';
    case Physical = 'physical';
}
