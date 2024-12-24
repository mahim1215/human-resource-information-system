<!-- PHP SCRIPT -->
<?php
include("db_connection.php");

// Fetch total employee count
$result = $conn->query("SELECT COUNT(*) AS count FROM employee");
$employeeCount = $result->fetch_assoc()['count'];

// Fetch all employees information based on department
$result = $conn->query("SELECT * FROM employee");
$employeeInfo = '';
while ($row = $result->fetch_assoc()) {
  $employeeInfo .= "<p>{$row['name']} - {$row['departmentId']}</p>";
}


// Fetch total earnings
$result = $conn->query("SELECT SUM(baseSalary) AS total FROM salary");
$totalEarnings = $result->fetch_assoc()['total'];

// Fetch attendances with employee names
$query = "
    SELECT a.employeeId, a.date, e.name 
    FROM attendance a
    JOIN employee e ON a.employeeId = e.employeeId
";
$result = $conn->query($query);
$attendances = '';
while ($row = $result->fetch_assoc()) {
  $attendances .= "<p>{$row['name']} - {$row['date']}</p>";
}
$data['attendances'] = $attendances;



// Fetch employee salaries
/*
$result = $conn->query("SELECT * FROM salary");
$employeeSalaries = '';
while ($row = $result->fetch_assoc()) {
    $employeeSalaries .= "<p>{$row['employeeId']} - {$row['baseSalary']}</p>";
}
*/

$query = "
    SELECT s.employeeId, s.baseSalary, e.name
    FROM salary s
    JOIN employee e ON s.employeeId = e.employeeId
";
$result = $conn->query($query);
$employeeSalaries = "";
while ($row = $result->fetch_assoc()) {
  $employeeSalaries .= "<p>{$row['name']} => {$row['baseSalary']}</p>";
}
$data['employeeSalaries'] = $employeeSalaries;





// Fetch contact info
$result = $conn->query("SELECT * FROM contacts");
$contactInfo = '';
while ($row = $result->fetch_assoc()) {
  $contactInfo .= "<p>{$row['contactPerson']} - {$row['department']} - {$row['phoneNumber']}</p>";
}

$conn->close();
?>



<!-- HTML SEGMENT -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">



  <div class="min-h-full">
    <nav class="bg-gray-800">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <img class="h-8 w-8" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
            </div>
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->

                <a href="departments.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Departments</a>
                <a href="projects.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Projects</a>
                <a href="clients.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Clients</a>
                <a href="job_applicants.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Jobs</a>
                <a href="calendar.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Calenders</a>
                <a href="leave_requests.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Leave Requests</a>
                <a href="view_attendance.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Attendance</a>
                <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Reports</a>

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

    <header class="bg-white shadow">
    
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Admin Dashboard</h1>
      </div>

      <div class="flex justify-center" >
        <a class="text-xl hover:underline font-medium" href="../index.php">view site</a>
      </div>
      <div class="flex justify-end" >
          <a class="text-xl font-bold tracking-tight cursor:pointer text-green-900 hover:underline" href="submit_attendance.php">Give Attendance</a>
      </div>

    </header>


    <main>
      <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">

        <!-- Dashboard Content Container -->
        <div class="container mx-auto my-8 bg-gray shadow-xl rounded-lg overflow-hidden">
          <!-- First Row of Flashy Cards -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6 p-6">

            <!-- Employees Card -->
            <a href="employees.php" class="flex flex-col justify-between h-full bg-gradient-to-r from-green-400 to-blue-500 text-white rounded-lg p-6 hover:scale-105 transition-transform duration-300">
              <div>
                <h2 class="text-3xl font-bold mb-2">Employees</h2>
                <p class="text-2xl">Total Employees: <?= $employeeCount ?></p>
              </div>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20a5 5 0 11-10 0 5 5 0 0110 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 9a5 5 0 00-5-5H1a5 5 0 015 5v14a5 5 0 005 5h14a5 5 0 005-5V9z"></path>
              </svg>
            </a>

            <!-- Total Earnings Card -->
            <a href="projects.php" class="flex flex-col justify-between h-full bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-lg p-6 hover:scale-105 transition-transform duration-300">
              <div>
                <h2 class="text-3xl font-bold mb-2">Total Earnings</h2>
                <p class="text-2xl">$<?= $totalEarnings ?></p>
              </div>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1z"></path>
              </svg>
            </a>
          </div>

          <!-- Second Row of Flashy Cards -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6 p-6">

            <!-- Attendances Card -->
            <a href="view_attendance.php" class="flex flex-col justify-between h-full bg-gradient-to-r from-red-400 to-pink-500 text-white rounded-lg p-6 hover:scale-105 transition-transform duration-300">
              <div>
                <h2 class="text-2xl font-bold mb-2">Attendances</h2>
                <div><?= $attendances ?></div>
              </div>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22c1.1 0 1.99-.9 1.99-2S13.1 18 12 18c-1.1 0-2.9-2 2s.9 2 2 2zm0-4c-1.1 0-2-.9-2-2s.9-2 2-2 2.9 2 2-.9 2-2 2zm0 16c-1.1 0-2-.9-2-2s.9-2 2-2 2.9 2 2-.9 2-2 2zm6-16c-1.1 0-2-.9-2-2s.9-2 2-2 2.9 2 2-.9 2-2 2zm-6 16c-1.1 0-2-.9-2-2s.9-2 2-2 2.9 2 2-.9 2-2 2zm6 0c-1.1 0-2-.9-2-2s.9-2 2-2 2.9 2 2-.9 2-2 2z"></path>
              </svg>
            </a>
           
            <!-- Employee Salaries Card -->
            <a href="view_salaries.php" class="flex flex-col justify-between h-full bg-gradient-to-r from-indigo-400 to-violet-500 text-white rounded-lg p-6 hover:scale-105 transition-transform duration-300">
              <div>
                <h2 class="text-2xl font-bold mb-2">Employee Salaries</h2>
                <div><?= $employeeSalaries ?></div>
              </div>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1z"></path>
              </svg>
            </a>
          </div>

          <!-- Contact Card -->
          <div class="mt-6 p-6">
            <a href="#" class="flex flex-col justify-between h-full bg-gradient-to-r from-green-400 to-blue-500 text-white rounded-lg p-6 hover:scale-105 transition-transform duration-300 w-full md:w-1/2 lg:w-1/3 mx-auto">
              <div>
                <h2 class="text-2xl font-bold mb-2">Contact</h2>
                <div><?= $contactInfo ?></div>
              </div>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1z"></path>
              </svg>
            </a>
          </div>

        </div>
      </div>
    </main>
</body>

</html>