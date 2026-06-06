<?php

declare(strict_types=1);

use App\Application\Appointments\CreateAppointment;
use App\Application\Appointments\CreateAppointmentData;
use App\Domain\Appointments\AppointmentStatus;
use App\Infrastructure\Ai\FakeAiRoutingProvider;
use App\Infrastructure\Notifications\TelegramNotifier;

it('creates an appointment and prepares an async notification payload', function (): void {
    $notifier = new TelegramNotifier();
    $useCase = new CreateAppointment(
        aiRoutingProvider: new FakeAiRoutingProvider(),
        telegramNotifier: $notifier,
    );

    $appointment = $useCase->handle(new CreateAppointmentData(
        patientName: 'Ivan Petrov',
        phone: '+79990000000',
        service: 'Psychotherapy consultation',
        preferredDate: new DateTimeImmutable('2026-06-15'),
        comment: 'Need an evening slot',
    ));

    expect($appointment->status)->toBe(AppointmentStatus::PendingConfirmation);
    expect($appointment->routingSummary)->toContain('Psychotherapy consultation');
    expect($notifier->sentMessages())->toHaveCount(1);
});
