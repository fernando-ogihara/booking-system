<?php
// book_appointment.php

// Include necessary files
require __DIR__ . '/config/database_config.php';
require __DIR__ . '/modules/validation_rules.php';
require __DIR__ . '/src/AppointmentRepository.php';

// Set headers here
header('Content-Type: application/json');

// Get data from request body and decode JSON
$data = json_decode(file_get_contents('php://input'), true);

// Validate appointment data
$errors = validateAppointmentData($data);

// If errors, return them as JSON response and exit
if (!empty($errors)) {
    echo json_encode(['error' => $errors]);
    exit;
}

// Instantiate AppointmentRepository
$appointmentRepository = new AppointmentRepository();

// Book the appointment
$result = $appointmentRepository->bookAppointment($data);

// Send JSON response
echo json_encode($result);
?>
