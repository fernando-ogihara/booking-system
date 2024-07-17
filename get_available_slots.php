<?php
// get_available_slots.php

// Include necessary files
require __DIR__ . '/config/database_config.php';
require __DIR__ . '/src/SlotRepository.php';

// Set headers here
header('Content-Type: application/json');

// DB connection
$pdo = getPdoConnection();

// Get date parameter from request, default to empty string if not provided
$date = $_GET['date'] ?? '';

// Instantiate SlotRepository
$slotRepository = new SlotRepository($pdo);

// Retrieve available slots
$response = $slotRepository->getAvailableSlots($date);

// Send JSON response
echo json_encode($response);
?>
