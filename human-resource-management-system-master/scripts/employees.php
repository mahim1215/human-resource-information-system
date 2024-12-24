<?php

include("db_connection.php");



// Function to get department name by departmentId
function getDepartmentName($conn, $departmentId)
{
    $query = "SELECT departmentName FROM departments WHERE departmentId = $departmentId";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['departmentName'];
    } else {
        return "Unknown";
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_employee'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $departmentId = $_POST['departmentId'];
    $jobTitle = $_POST['jobTitle'];
    $dateOfJoining = $_POST['dateOfJoining'];
    $baseSalary = $_POST['baseSalary'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
   

    // Insert new employee into database
    $stmt = $conn->prepare("INSERT INTO employee (name, email, phone, address, departmentId, jobTitle, dateOfJoining, baseSalary, username, password, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssissssss", $name, $email, $phone, $address, $departmentId, $jobTitle, $dateOfJoining, $baseSalary, $username, $password, $role);
    
    $stmt->execute();
    
    $stmt->close();

} elseif (isset($_POST['delete_employee'])) {
    $employeeId = $_POST['employeeId'];

    // Check if the employee is the head of any department
    $stmt_check = $conn->prepare("SELECT * FROM department WHERE headOfDepartment = ?");
    $stmt_check->bind_param("i", $employeeId);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Employee is head of a department, handle accordingly (reassign or prevent deletion)
        // For now, let's prevent deletion and display an error message
        echo "Cannot delete employee as they are the head of a department. Please reassign the head of department before deleting.";
        header("Location: error.php");
    } else {
        // No department headship, proceed with deletion
        $stmt_delete = $conn->prepare("DELETE FROM employee WHERE employeeId = ?");
        $stmt_delete->bind_param("i", $employeeId);
        $stmt_delete->execute();
        // Check if deletion was successful
        if ($stmt_delete->affected_rows > 0) {
            echo "Employee deleted successfully.";
        } else {
            echo "Error deleting employee.";
        }
    }

    // Close statements
    $stmt_check->close();
    $stmt_delete->close();
}




// Fetch employees grouped by department
$query = "
    SELECT e.*, d.departmentName
    FROM employee e
    JOIN department d ON e.departmentId = d.departmentId
    ORDER BY e.departmentId, e.name
";
$result = $conn->query($query);

$employees = array();
while ($row = $result->fetch_assoc()) {
    $departmentName = $row['departmentName'];
    if (!isset($employees[$departmentName])) {
        $employees[$departmentName] = array();
    }
    $employees[$departmentName][] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <!-- NAVIGATION -->
    <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">

                        <div class="flex-shrink-0">
                            <a href="admin_dashboard.php">
                                <img class="h-8 w-8" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company"></a>
                        </div>

                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->

                                <a href="departments.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Departments</a>
                                <a href="projects.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Projects</a>
                                <a href="clients.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Clients</a>
                                <a href="job_applicants.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Applications</a>
                                <a href="calendar.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Calenders</a>
                                <a href="leave_requests.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Leave Requests</a>
                                <a href="view_attendance.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Attendance</a>
                
                                <a href="reports.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Reports</a>

                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <button type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">View notifications</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                </svg>
                            </button>

                            <!-- Profile dropdown -->
                            <div class="relative ml-3">
                                <div>
                                    <button type="button" class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="absolute -inset-1.5"></span>
                                        <span class="sr-only">Open user menu</span>
                                        <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <button type="button" class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="absolute -inset-0.5"></span>
                            <span class="sr-only">Open main menu</span>
                            <!-- Menu open: "hidden", Menu closed: "block" -->
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <!-- Menu open: "block", Menu closed: "hidden" -->
                            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

        </nav>
    </div>

    <!-- Header -->
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Employee List</h1>
        </div>
    </header>

    <!-- Employee List -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <?php foreach ($employees as $department => $departmentEmployees) : ?>
            <div class="mb-6">
                <h2 class="text-2xl font-bold mb-2"><?php echo $department; ?></h2>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($departmentEmployees as $employee) : ?>
                        <div class="bg-white shadow-md rounded-lg p-4">
                            <h3 class="text-lg font-bold mb-2"><?php echo $employee['name']; ?></h3>
                            <p class="text-sm mb-2"><?php echo $employee['email']; ?></p>
                            <p class="text-sm mb-2"><?php echo $employee['jobTitle']; ?></p>
                            <p class="text-sm mb-2">Department: <?php echo $employee['departmentName']; ?></p>
                            <form method="POST" action="">
                                <input type="hidden" name="employeeId" value="<?php echo $employee['employeeId']; ?>">
                                <button type="submit" name="view_employee" class="bg-blue-500 text-white px-4 py-2 rounded">View Details</button>
                                <button type="submit" name="delete_employee" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Add Employee Button 
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <form method="POST" action="add_employee.php">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Add Employee</button>
        </form>
    </div>
    -->

    <!-- Add Employee Form -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="flex items-center justify-center text-3xl font-bold">Add New Employee</h1> &nbsp;
        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="departmentId" class="block text-sm font-medium text-gray-700">Department ID</label>
                    <input type="number" name="departmentId" id="departmentId" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="jobTitle" class="block text-sm font-medium text-gray-700">Job Title</label>
                    <input type="text" name="jobTitle" id="jobTitle" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="dateOfJoining" class="block text-sm font-medium text-gray-700">Date of Joining</label>
                    <input type="date" name="dateOfJoining" id="dateOfJoining" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="baseSalary" class="block text-sm font-medium text-gray-700">Base Salary</label>
                    <input type="number" name="baseSalary" id="baseSalary" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" step="0.01" required>
                </div>
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" id="username" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="Employee">Employee</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>


                <div>
                    <button type="submit" name="add_employee" class="bg-blue-500 text-white px-4 py-2 rounded">Add Employee</button>
                </div>
            </form>
        </div>
    </div>



</body>

</html>