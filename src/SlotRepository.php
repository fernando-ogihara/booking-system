<?php

declare(strict_types=1);

// Include constants file
require_once 'constants.php';

// Define the SlotRepository class
class SlotRepository {
    // Private property to hold the database connection
    private $pdo;

    // Constructor to initialize the database connection
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Get available slots for a given date.
     *
     * @param string $date The date to check for available slots.
     * @return array The available slots or an error message.
     */
    public function getAvailableSlots($date) {
        // Check if no date is provided and correct or if the date is in the past
        if (empty($date) || strlen($date) !== 10) {
            return ['error' => 'Invalid date provided. Date format must be YYYY-MM-DD.'];
        } elseif (strtotime($date) < strtotime('today')) {
            return ['error' => 'Date provided is in the past.'];
        }

        // Query to select booked slots for the given date
        $sql = 'SELECT slot FROM appointments WHERE date = :date';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['date' => $date]);

        // Fetch all booked slots
        $bookedSlots = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Calculate available slots by finding the difference between all slots and booked slots
        $availableSlots = array_diff(ALL_SLOTS, $bookedSlots);

        // Return available slots
        return ['availableSlots' => $availableSlots];
    }
}
?>
