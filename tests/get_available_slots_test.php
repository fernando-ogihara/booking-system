<?php

/**
 * This script tests the availability of slots by sending a GET request to the get_available_slots.php endpoint.
 * It then checks if the response contains the expected structure and prints the available slots if successful.
 *
 * Usage: This script can be executed via the command line or accessed through a browser.
 * It requires the get_available_slots.php script to be accessible at http://localhost/get_available_slots.php.
 * Ensure that the script is properly configured to communicate with the endpoint and handle responses.
 */

// Function to test availability slots for a given date
function testAvailability($date) {
    // Construct the URL
    $url = "http://localhost/get_available_slots.php?date=$date";

    // Send a GET request to the endpoint
    $response = file_get_contents($url);

    // Decode the JSON response
    $json_response = json_decode($response, true);

    // Check if the response contains the expected structure
    if (isset($json_response['availableSlots']) && is_array($json_response['availableSlots'])) {
        // Test passed
        echo "Test passed: Available slots retrieved successfully for $date.\n";
        // Print the available slots
        echo "Available slots for $date: " . implode(', ', $json_response['availableSlots']) . "\n";
    } else {
        // Test failed
        echo "Test failed: Unable to retrieve available slots or invalid response for $date.\n";
    }
}

// Test for an empty date
echo "Testing for empty date:\n";
testAvailability('');

// Test for a date in the past
echo "\nTesting for a date in the past:\n";
testAvailability('2024-05-10');

// Test for an invalid date format
echo "\nTesting for an invalid date format:\n";
testAvailability('2024-05-40');

?>
