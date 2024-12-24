<?php

include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employeeId = $_POST['employeeId'];
    $date = $_POST['date'];
    $clockInTime = $_POST['clockInTime'];
    $clockOutTime = $_POST['clockOutTime'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO attendance (employeeId, date, clockInTime, clockOutTime, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $employeeId, $date, $clockInTime, $clockOutTime, $status);

    if ($stmt->execute()) {
        echo "Attendance submitted successfully.";
        header("Location: employee_dashboard.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">


 <!-- Header -->
 <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900"></h1>
        </div>
    </header>


    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Submit Attendance</h1>
       
        <form action="" method="post">
            <div class="mb-4">
                <label for="employeeId" class="block text-sm font-medium text-gray-700">Employee ID</label>
                <input type="number" name="employeeId" id="employeeId" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="date" id="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="clockInTime" class="block text-sm font-medium text-gray-700">Clock In Time</label>
                <input type="time" name="clockInTime" id="clockInTime" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="clockOutTime" class="block text-sm font-medium text-gray-700">Clock Out Time</label>
                <input type="time" name="clockOutTime" id="clockOutTime" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded shadow-md hover:bg-blue-700 transition duration-300">Submit Attendance</button>
        </form>
    </div>
    
</body>

</html>