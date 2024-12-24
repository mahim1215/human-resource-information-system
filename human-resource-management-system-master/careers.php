<?php

include("scripts/db_connection.php");

$sql = "SELECT * FROM jobs";
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Careers</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-5">Current Job Openings</h2>
        <div class="bg-white p-8 rounded shadow-md">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="mb-4 p-4 border <?= (strtotime($row['deadline']) < time()) ? 'border-red-500 bg-red-100' : 'border-gray-300 bg-gray-50' ?> rounded">
                    <h3 class="text-xl font-semibold"><?= $row['position_name'] ?></h3>
                    <p>Location: <?= $row['location'] ?></p>
                    <p>Salary: <?= $row['salary_range'] ?></p>
                    <p>Experience Required: <?= $row['experience_years'] ?> years</p>
                    <p>Deadline: <?= $row['deadline'] ?></p>
                    <p>Job Type: <?= $row['job_type'] ?></p>
                    <p>Qualifications: <?= $row['qualifications'] ?></p>
                    <p>Benefits: <?= $row['benefits'] ?></p>
                    <p>Educational Requirement: <?= $row['education_requirement'] ?></p>
                    <a href="jobs_apply.php?job_id=<?= $row['id'] ?>" target="_blank" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 mt-2 inline-block">Apply</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>
<?php
$conn->close();
?>