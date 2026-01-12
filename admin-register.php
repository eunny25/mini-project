<?php
/**
 * Admin User Initialization Script
 * This script automatically creates the admin user in the database
 * 
 * Admin Credentials:
 * Username: Eunice Edwin
 * Email: eune.2502@gmail.com
 * Password: eunny@#25 (hashed using password_hash)
 * Role: admin
 * phone: 0678154511
 */

// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Update with your MySQL password
$database = "internship_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        'status' => 'error',
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]));
}

// Admin credentials
$adminName = "Eunice Edwin";
$adminEmail = "eune.2502@gmail.com";
$adminPassword = "eunny@#25";
$adminPhone = "0678154511";
$hashedPassword = password_hash($adminPassword, PASSWORD_BCRYPT);

// Check if admin already exists
$checkQuery = "SELECT id FROM users WHERE email = ? AND role = 'admin'";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param("s", $adminEmail);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        'status' => 'info',
        'message' => 'Admin user already exists',
        'email' => $adminEmail
    ]);
    $checkStmt->close();
    $conn->close();
    exit;
}

// Insert admin user
$insertQuery = "INSERT INTO users (name, email, password, role, phone, is_active, created_at, updated_at) 
                VALUES (?, ?, ?, 'admin', ?, TRUE, NOW(), NOW())";
$insertStmt = $conn->prepare($insertQuery);
$insertStmt->bind_param("ssss", $adminName, $adminEmail, $hashedPassword, $adminPhone);

if ($insertStmt->execute()) {
    $adminId = $conn->insert_id;
    
    // Log admin creation
    $logMessage = "Admin user 'Eunice Edwin' created successfully with ID: " . $adminId;
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Admin user registered successfully',
        'admin' => [
            'id' => $adminId,
            'name' => $adminName,
            'email' => $adminEmail,
            'phone' => $adminPhone,
            'role' => 'admin',
            'created_at' => date('Y-m-d H:i:s')
        ]
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to create admin user: ' . $conn->error
    ]);
}

$insertStmt->close();
$conn->close();
?>
