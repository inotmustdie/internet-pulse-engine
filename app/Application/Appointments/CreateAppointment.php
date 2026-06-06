<?php

declare(strict_types=1);

namespace App\Application\Appointments;

use App\Domain\Appointments\Appointment;
use App\Domain\Appointments\AppointmentStatus;
use App\Infrastructure\Ai\AiRoutingProvider;
use App\Infrastructure\Notifications\TelegramNotifier;

final readonly class CreateAppointment
{
    public function __construct(
        private AiRoutingProvider $aiRoutingProvider,
        private TelegramNotifier $telegramNotifier,
    ) {
    }

    public function handle(CreateAppointmentData $data): Appointment
    {
        $summary = $this->aiRoutingProvider->summarizeRouting(
            service: $data->service,
            comment: $data->comment,
        );

        $appointment = new Appointment(
            id: 'apt_' . bin2hex(random_bytes(4)),
            patientName: $data->patientName,
            phone: $data->phone,
            service: $data->service,
            preferredDate: $data->preferredDate,
            status: AppointmentStatus::PendingConfirmation,
            comment: $data->comment,
            routingSummary: $summary,
        );

        // In Laravel this call should usually dispatch a queued job instead of
        // performing network IO in the request lifecycle.
        $this->telegramNotifier->notifyAppointmentCreated($appointment);

        return $appointment;
    }
}
