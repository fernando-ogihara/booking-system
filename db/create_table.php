<?php
// create_table.php

// Include database configuration file
require '../config/database_config.php';

// Establish database connection
$pdo = getPdoConnection();

// SQL query to create appointments table
$sql = "CREATE TABLE IF NOT EXISTS appointments (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(50) NOT NULL,
    phone VARCHAR(15),
    date DATE NOT NULL,
    slot VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

try {
    // Execute the SQL query
    $pdo->exec($sql);
    echo "Table 'appointments' created successfully";
} catch (PDOException $e) {
    // Handle any errors that occur during table creation
    echo "Error creating table: " . $e->getMessage();
}
?>
