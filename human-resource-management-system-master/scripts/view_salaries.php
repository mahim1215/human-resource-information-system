<?php
include("db_connection.php");

// Handle salary updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $salaryId = $_POST['salaryId'];
    $bonuses = $_POST['bonuses'];
    $deductions = $_POST['deductions'];
    $baseSalary = $_POST['baseSalary'];
    $paymentDate = $_POST['paymentDate'];

    $stmt = $conn->prepare("UPDATE salary SET bonuses = ?, deductions = ?, baseSalary = ?, paymentDate = ? WHERE salaryId = ?");
    $stmt->bind_param("ddssi", $bonuses, $deductions, $baseSalary, $paymentDate, $salaryId);

    if ($stmt->execute()) {
        $success_message = "Salary updated successfully.";
    } else {
        $error_message = "Error updating salary.";
    }

    $stmt->close();
}

// Fetch all salaries with employee names
$query = "
    SELECT s.salaryId, s.employeeId, s.bonuses, s.deductions, s.baseSalary, s.paymentDate, e.name
    FROM salary s
    JOIN employee e ON s.employeeId = e.employeeId
";
$result = $conn->query($query);

$salaries = '';
while ($row = $result->fetch_assoc()) {
    $salaries .= "
        <tr>
            <form action='view_update_salaries.php' method='POST'>
                <input type='hidden' name='salaryId' value='{$row['salaryId']}'>
                <td class='px-4 py-2 border'>{$row['name']}</td>
                <td class='px-4 py-2 border'>
                    <input type='number' step='0.01' name='bonuses' value='{$row['bonuses']}' class='mt-1 block w-full border-gray-300 rounded-md shadow-sm'>
                </td>
                <td class='px-4 py-2 border'>
                    <input type='number' step='0.01' name='deductions' value='{$row['deductions']}' class='mt-1 block w-full border-gray-300 rounded-md shadow-sm'>
                </td>
                <td class='px-4 py-2 border'>
                    <input type='number' step='0.01' name='baseSalary' value='{$row['baseSalary']}' class='mt-1 block w-full border-gray-300 rounded-md shadow-sm'>
                </td>
                <td class='px-4 py-2 border'>
                    <input type='date' name='paymentDate' value='{$row['paymentDate']}' class='mt-1 block w-full border-gray-300 rounded-md shadow-sm'>
                </td>
                <td class='px-4 py-2 border'>
                    <button type='submit' class='bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-700 transition duration-300'>Update</button>
                </td>
            </form>
        </tr>
    ";
}

$conn->close();
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
                                <a href="calendar.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Calendar</a>
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
            <h1 class="text-3xl font-bold tracking-tight text-gray-900"></h1>
        </div>
    </header>

    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">View and Update Salaries</h1>

        <?php if (isset($success_message)) {
            echo "<p class='text-green-500'>$success_message</p>";
        } ?>
        <?php if (isset($error_message)) {
            echo "<p class='text-red-500'>$error_message</p>";
        } ?>

        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">Employee Name</th>
                    <th class="px-4 py-2 border">Bonuses</th>
                    <th class="px-4 py-2 border">Deductions</th>
                    <th class="px-4 py-2 border">Base Salary</th>
                    <th class="px-4 py-2 border">Payment Date</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $salaries; ?>
            </tbody>
        </table>
    </div>

</body>

</html>