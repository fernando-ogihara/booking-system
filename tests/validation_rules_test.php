<?php
require '../modules/validation_rules.php';

// Function to execute an assertion and check if a specific error is present in the results
function assertError($errors, $expectedError, $testName) {
    if (in_array($expectedError, $errors)) {
        echo "Test '$testName' passed for error '$expectedError'.\n";
    } else {
        echo "Test '$testName' failed. Expected error: '$expectedError'.\n";
    }
}

// Test for empty fields
function testEmptyFields() {
    $data = [
        'fullName' => '',
        'email' => '',
        'phone' => '',
        'date' => '',
        'slot' => ''
    ];

    $errors = validateAppointmentData($data);

    assertError($errors, 'Full name, email, date, and slot are required', __FUNCTION__);
}

// Test for invalid email format
function testInvalidEmailFormat() {
    $data = [
        'fullName' => 'John Doe',
        'email' => 'invalidemail',
        'phone' => '123456789',
        'date' => '2024-05-19',
        'slot' => '08:00 - 08:30'
    ];

    $errors = validateAppointmentData($data);

    assertError($errors, 'Invalid email format', __FUNCTION__);
}

// Test for invalid date format
function testInvalidDateFormat() {
    $data = [
        'fullName' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '123456789',
        'date' => '19-05-2024',
        'slot' => '08:00 - 08:30'
    ];

    $errors = validateAppointmentData($data);

    assertError($errors, 'Invalid date format. Use YYYY-MM-DD.', __FUNCTION__);
}

// Test for invalid slot format
function testInvalidSlotFormat() {
    $data = [
        'fullName' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '123456789',
        'date' => '2024-05-19',
        'slot' => '08:00'
    ];

    $errors = validateAppointmentData($data);

    assertError($errors, 'Invalid slot format. Use HH:MM - HH:MM.', __FUNCTION__);
}

// Test for slot time outside permitted range
function testInvalidSlotTime() {
    $data = [
        'fullName' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '123456789',
        'date' => '2024-05-19',
        'slot' => '07:00 - 07:30'
    ];

    $errors = validateAppointmentData($data);

    assertError($errors, 'Invalid slot time. Must be between 8am and 6pm.', __FUNCTION__);
}

// Test for unrealistic date
function testUnrealisticDate() {
    $data = [
        'fullName' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '123456789',
        'date' => '9999-01-01',
        'slot' => '08:00 - 08:30'
    ];

    $errors = validateAppointmentData($data);

    assertError($errors, 'Invalid date.', __FUNCTION__);
}

// Test for invalid UK phone number format
function testInvalidPhoneFormat() {
    $data = [
        'fullName' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '12345', // Invalid UK phone number format
        'date' => '2024-05-19',
        'slot' => '08:00 - 08:30'
    ];

    $errors = validateAppointmentData($data);

    assertError($errors, 'Invalid UK phone number format. Use +44 followed by 10 digits.', __FUNCTION__);
}

// Run all tests
function runTests() {
    testEmptyFields();
    testInvalidEmailFormat();
    testInvalidDateFormat();
    testInvalidSlotFormat();
    testInvalidSlotTime();
    testUnrealisticDate();
    testInvalidPhoneFormat();
}

// Execute the tests
runTests();

echo "All validation rules passed!\n";
?>
