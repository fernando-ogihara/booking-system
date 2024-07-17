<?php

declare(strict_types=1);

/**
 * This script tests the booking appointments functionality by simulating a POST request
 * to the book_appointment.php endpoint with predefined test data.
 *
 * It constructs the URL dynamically based on the server environment and sends the request.
 * The response is then printed to the console for verification.
 *
 * Usage: This script can be executed via the command line or accessed through a browser.
 * Ensure that the book_appointment.php endpoint is properly configured to handle the request
 * and return the appropriate response.
 */


// Include necessary files
require '../config/database_config.php';
require '../modules/validation_rules.php';
require '../src/AppointmentRepository.php';

/**
 * Simulate a POST request.
 *
 * @param string $url The URL to send the POST request to.
 * @param array $data The data to include in the POST request.
 * @return string The response from the server.
 */
function simulatePostRequest($url, $data) {
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($data)
        ]
    ];
    $context = stream_context_create($options);
    return file_get_contents($url, false, $context);
}

/**
 * Run tests for booking appointments.
 */
function runTests() {
    // Mocking the request data (just remember to update the date or slot)
    $requestData = [
        'fullName' => 'Janet Doe',
        'email' => 'janet@example.com',
        'phone' => '+440123457890',
        'date' => '2024-05-24',
        'slot' => '08:30 - 09:00'
    ];
    // Construct the URL dynamically based on the server environment
    $serverName = $_SERVER['SERVER_NAME'] ?? 'localhost';
    $serverPort = $_SERVER['SERVER_PORT'] ?? '80';
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

    // Include default values for server name and port
    $serverName = $serverName ?? 'localhost';
    $serverPort = $serverPort ?? '80';

    // Only include the port if it's not the default (80 for HTTP, 443 for HTTPS)
    $port = ($scheme === 'https' && $serverPort === '443') || ($scheme === 'http' && $serverPort === '80') ? '' : ":$serverPort";

    $url = "$scheme://$serverName$port/book_appointment.php";

    $response = simulatePostRequest($url, $requestData);
    
    echo "Test Case 1: Valid appointment data\n";
    echo $response . "\n";
}

// Run the tests
runTests();
?>
