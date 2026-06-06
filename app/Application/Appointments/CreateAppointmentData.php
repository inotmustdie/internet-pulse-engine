<?php

declare(strict_types=1);

namespace App\Application\Appointments;

use DateTimeImmutable;
use InvalidArgumentException;

final readonly class CreateAppointmentData
{
    public function __construct(
        public string $patientName,
        public string $phone,
        public string $service,
        public DateTimeImmutable $preferredDate,
        public ?string $comment = null,
    ) {
        if (trim($this->patientName) === '') {
            throw new InvalidArgumentException('Patient name is required.');
        }

        if (trim($this->phone) === '') {
            throw new InvalidArgumentException('Phone is required.');
        }

        if (trim($this->service) === '') {
            throw new InvalidArgumentException('Service is required.');
        }
    }
}
