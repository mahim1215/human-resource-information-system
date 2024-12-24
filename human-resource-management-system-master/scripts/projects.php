<?php

include("db_connection.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_project'])) {
        $clientId = $_POST['clientId'];
        $projectName = $_POST['projectName'];
        $description = $_POST['description'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $totalEarnings = $_POST['totalEarnings'];
        $status = 'Ongoing'; // Default to Ongoing when adding a project

        $stmt = $conn->prepare("INSERT INTO services (clientId, projectName, description, startDate, endDate, totalEarnings, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssds", $clientId, $projectName, $description, $startDate, $endDate, $totalEarnings, $status);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete_project'])) {
        $serviceId = $_POST['serviceId'];
        $stmt = $conn->prepare("DELETE FROM services WHERE serviceId = ?");
        $stmt->bind_param("i", $serviceId);
        $stmt->execute();
        $stmt->close();
    }
}

$query = "
    SELECT s.serviceId, s.projectName, c.name, s.description, s.startDate, s.endDate, s.totalEarnings, s.status
    FROM services s
    JOIN clients c ON s.clientId = c.clientId
    ORDER BY FIELD(s.status, 'Ongoing', 'Completed'), s.startDate
";
$result = $conn->query($query);

$projects = '';
while ($row = $result->fetch_assoc()) {
    $projects .= '<tr>
        <td class="border px-4 py-2">' . $row['projectName'] . '</td>
        <td class="border px-4 py-2">' . $row['name'] . '</td>
        <td class="border px-4 py-2">' . $row['description'] . '</td>
        <td class="border px-4 py-2">' . $row['startDate'] . '</td>
        <td class="border px-4 py-2">' . $row['endDate'] . '</td>
        <td class="border px-4 py-2">' . $row['totalEarnings'] . '</td>
        <td class="border px-4 py-2">' . $row['status'] . '</td>
        <td class="border px-4 py-2">
            <form method="POST">
                <input type="hidden" name="serviceId" value="' . $row['serviceId'] . '">
                <button type="submit" name="delete_project" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
            </form>
        </td>
    </tr>';
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
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Projects</h1>
    </div>
</header>

<!-- Add Project Form -->
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <h2 class="text-2xl font-bold mb-4">Add Project</h2>
        <form method="POST" class="grid grid-cols-1 gap-4">
            <div>
                <label for="clientId" class="block text-sm font-medium text-gray-700">Client ID</label>
                <input type="number" name="clientId" id="clientId" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="projectName" class="block text-sm font-medium text-gray-700">Project Name</label>
                <input type="text" name="projectName" id="projectName" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <input type="text" name="description" id="description" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" name="startDate" id="startDate" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="endDate" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" name="endDate" id="endDate" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="totalEarnings" class="block text-sm font-medium text-gray-700">Amount (BDT)</label>
                <input type="number" step="0.01" name="totalEarnings" id="totalEarnings" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <button type="submit" name="add_project" class="bg-indigo-500 text-white px-4 py-2 rounded">Add Project</button>
        </form>
    </div>

    <!-- Projects List -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Project Name</th>
                    <th class="border px-4 py-2">Client Name</th>
                    <th class="border px-4 py-2">Description</th>
                    <th class="border px-4 py-2">Start Date</th>
                    <th class="border px-4 py-2">End Date</th>
                    <th class="border px-4 py-2">Total Earnings</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $projects; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>