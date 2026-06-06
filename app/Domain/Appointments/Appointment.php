<?php

declare(strict_types=1);

namespace App\Domain\Appointments;

use DateTimeImmutable;

final readonly class Appointment
{
    public function __construct(
        public string $id,
        public string $patientName,
        public string $phone,
        public string $service,
        public DateTimeImmutable $preferredDate,
        public AppointmentStatus $status,
        public ?string $comment = null,
        public ?string $routingSummary = null,
    ) {
    }
}
