<?php
// Include the database connection script
include("db_connection.php");

// Start the session
session_start();



// Retrieve username and password from form
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare and execute the SQL query
$sql = "SELECT * FROM Employee WHERE username =? AND password =?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password); // "ss" means two strings

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // User found, check their role
        $role = $row['role'];

        $_SESSION['username'] = $username;
        $_SESSION['employeeName'] = $row['name'];
        $_SESSION['userId'] = $row['employeeId'];

        // Redirect based on role
        if ($role == 'employee') {
            // Redirect to employee dashboard
            header("Location: employee_dashboard.php");
        } else if ($role == 'admin') {
            // Redirect to admin dashboard
            header("Location: admin_dashboard.php");
        }
    } else {
        // Invalid credentials, redirect back to login page
       header("Location: error.php");
    }
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

