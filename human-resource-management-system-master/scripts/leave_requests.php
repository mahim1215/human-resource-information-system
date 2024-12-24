<?php

include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['approve_leave'])) {
        $leaveId = $_POST['leaveId'];
        $employeeId = $_POST['employeeId'];

        $stmt = $conn->prepare("UPDATE leave_requests SET leave_status = 'Approved' WHERE id = ?");
        $stmt->bind_param("i", $leaveId);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("UPDATE employee SET leave_request = 'Approved' WHERE employeeId = ?");
        $stmt->bind_param("i", $employeeId);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['reject_leave'])) {
        $leaveId = $_POST['leaveId'];
        $employeeId = $_POST['employeeId'];

        $stmt = $conn->prepare("UPDATE leave_requests SET leave_status = 'Rejected' WHERE id = ?");
        $stmt->bind_param("i", $leaveId);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("UPDATE employee SET leave_request = 'Rejected' WHERE employeeId = ?");
        $stmt->bind_param("i", $employeeId);
        $stmt->execute();
        $stmt->close();
    }
}

$query = "
    SELECT lr.id, lr.employeeId, lr.from_date, lr.to_date, lr.reason, lr.departmentId, lr.jobTitle, lr.email, lr.leave_status,
           e.name AS employee_name
    FROM leave_requests lr
    JOIN employee e ON lr.employeeId = e.employeeId
";
$result = $conn->query($query);

$leave_requests = '';

while ($leave = $result->fetch_assoc()) {
   
    $status = $leave['leave_status'] == 'Applied' ? 'Pending' : ($leave['leave_status'] == 'Approved' ? 'Approved' : 'Rejected');
   
    $leave_requests .= '<div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <div class="mb-4">
            <p class="text-lg font-bold">' . $leave['employee_name'] . '</p>
            <p class="text-sm">Department ID: ' . $leave['departmentId'] . '</p>
            <p class="text-sm">Job Title: ' . $leave['jobTitle'] . '</p>
            <p class="text-sm">Email: ' . $leave['email'] . '</p>
            <p class="text-sm">From: ' . $leave['from_date'] . '</p>
            <p class="text-sm">To: ' . $leave['to_date'] . '</p>
            <p class="text-sm">Reason: ' . $leave['reason'] . '</p>
            <p class="text-sm">Status: ' . $status . '</p>
        </div>
        <div class="flex space-x-4">
            <form method="POST">
                <input type="hidden" name="leaveId" value="' . $leave['id'] . '">
                <input type="hidden" name="employeeId" value="' . $leave['employeeId'] . '">
                <button type="submit" name="approve_leave" class="bg-green-500 text-white px-4 py-2 rounded">Approve</button>
            </form>
            <form method="POST">
                <input type="hidden" name="leaveId" value="' . $leave['id'] . '">
                <input type="hidden" name="employeeId" value="' . $leave['employeeId'] . '">
                <button type="submit" name="reject_leave" class="bg-red-500 text-white px-4 py-2 rounded">Reject</button>
            </form>
        </div>
    </div>';
}
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaves</title>
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
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Leave Requests</h1>
    </div>
</header>

<!-- Leave Requests List -->
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <?php echo $leave_requests; ?>
</div>

</body>
</html>