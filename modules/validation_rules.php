<?php

declare(strict_types=1);

// validation_rules.php

/**
 * Validate appointment data.
 *
 * @param array $data The data to validate.
 * @return array An array of error messages, if any.
 */
function validateAppointmentData($data) {
    $errors = [];

    $fullName = trim($data['fullName'] ?? '');
    $email = trim($data['email'] ?? '');
    $phone = trim($data['phone'] ?? '');
    $date = trim($data['date'] ?? '');
    $slot = trim($data['slot'] ?? '');

    // Checking for required fields
    if (empty($fullName) || empty($email) || empty($date) || empty($slot)) {
        $errors[] = 'Full name, email, date, and slot are required';
    }

    // Validating email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }

    // Validating UK phone number format (including country code)
    if (!preg_match('/^\+44\d{10}$/', $phone)) {
        $errors[] = 'Invalid UK phone number format. Use +44 followed by 10 digits.';
    }

    // Validating date format (YYYY-MM-DD)
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        $errors[] = 'Invalid date format. Use YYYY-MM-DD.';
    }

    // Validating slot format (HH:MM - HH:MM)
    if (!preg_match('/^\d{2}:\d{2} - \d{2}:\d{2}$/', $slot)) {
        $errors[] = 'Invalid slot format. Use HH:MM - HH:MM.';
    } else {
        // Check if the slot has the expected format before accessing its elements
        $slotParts = explode(' - ', $slot);
        if (count($slotParts) !== 2) {
            $errors[] = 'Invalid slot format. Use HH:MM - HH:MM.';
        } else {
            // Check if the start and end times of the slot are valid
            $startTime = strtotime('08:00');
            $endTime = strtotime('18:00');
            $startSlot = strtotime($slotParts[0]);
            $endSlot = strtotime($slotParts[1]);
            if ($startSlot < $startTime || $endSlot > $endTime) {
                $errors[] = 'Invalid slot time. Must be between 8am and 6pm.';
            }
        }
    }

    // Check if the date is realistic (not too far in the past or future)
    $currentDate = date('Y-m-d');
    if ($date < $currentDate || $date > date('Y-m-d', strtotime('+1 year'))) {
        $errors[] = 'Invalid date.';
    }

    return $errors;
}

?>
