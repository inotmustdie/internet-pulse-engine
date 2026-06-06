<?php

declare(strict_types=1);

namespace App\Domain\Appointments;

enum AppointmentStatus: string
{
    case PendingConfirmation = 'pending_confirmation';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
}
