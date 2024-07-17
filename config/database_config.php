<?php

declare(strict_types=1);

// database_config.php

/**
 * Establish a PDO database connection.
 *
 * @return PDO The PDO instance representing the database connection.
 */
function getPdoConnection() {
    // Database connection parameters
    $host = 'localhost';
    $db = 'booking';
    $user = 'root';
    $pass = '';

    try {
        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

        // Set PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Return the PDO instance
        return $pdo;
    } catch (PDOException $e) {
        // Handle connection errors
        die("Connection failed: " . $e->getMessage());
    }
}
?>
