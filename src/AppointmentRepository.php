<?php

declare(strict_types=1);

// Define the AppointmentRepository class
class AppointmentRepository {
    // Private property to hold the database connection
    private $pdo;

    // Constructor to initialize the database connection
    public function __construct() {
        $this->pdo = getPdoConnection();
    }

    /**
     * Book an appointment.
     *
     * @param array $data The appointment data.
     * @return array The result of the booking process.
     */
    public function bookAppointment($data) {
        // Validate appointment data
        $errors = validateAppointmentData($data);

        // If there are validation errors, return them
        if (!empty($errors)) {
            return ['error' => $errors];
        }

        // Check if the slot is already booked
        $isBooked = $this->isSlotBooked($data['date'], $data['slot']);
        if ($isBooked) {
            return ['error' => 'Slot is already booked'];
        }

        // Insert the new appointment into the database
        try {
            $sql = 'INSERT INTO appointments (full_name, email, phone, date, slot) VALUES (:full_name, :email, :phone, :date, :slot)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'full_name' => $data['fullName'], 
                'email' => $data['email'], 
                'phone' => $data['phone'],
                'date' => $data['date'], 
                'slot' => $data['slot']
            ]);
            return ['success' => 'Appointment booked'];
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Check if a slot is already booked.
     *
     * @param string $date The date of the appointment.
     * @param string $slot The time slot of the appointment.
     * @return bool True if the slot is booked, false otherwise.
     */
    private function isSlotBooked($date, $slot) {
        $sqlCheck = 'SELECT COUNT(*) FROM appointments WHERE date = :date AND slot = :slot';
        $stmtCheck = $this->pdo->prepare($sqlCheck);
        $stmtCheck->execute(['date' => $date, 'slot' => $slot]);
        return (bool)$stmtCheck->fetchColumn();
    }
}
?>
