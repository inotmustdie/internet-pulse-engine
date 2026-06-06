<?php

declare(strict_types=1);

namespace App\Infrastructure\Notifications;

use App\Domain\Appointments\Appointment;

final class TelegramNotifier
{
    /** @var list<string> */
    private array $messages = [];

    public function notifyAppointmentCreated(Appointment $appointment): void
    {
        $this->messages[] = sprintf(
            'New appointment request: %s, service: %s, preferred date: %s',
            $appointment->patientName,
            $appointment->service,
            $appointment->preferredDate->format('Y-m-d'),
        );
    }

    /** @return list<string> */
    public function sentMessages(): array
    {
        return $this->messages;
    }
}
