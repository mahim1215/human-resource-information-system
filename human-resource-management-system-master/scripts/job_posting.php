<?php

// include the database connection
include("db_connection.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Take all the inputs from HR of job post form

    $position_name = $_POST['position_name'];
    $vacancy = $_POST['vacancy'];
    $deadline = $_POST['deadline'];

    $experience_years = $_POST['experience_years'];
    $location = $_POST['location'];
    $salary_range = $_POST['salary_range'];

    $job_type = $_POST['job_type'];
    $qualifications = $_POST['qualifications'];
    $benefits = $_POST['benefits'];

    $education_requirement = $_POST['education_requirement'];



    $sql = "INSERT INTO jobs (position_name, vacancy, deadline, experience_years, location, salary_range, job_type, qualifications, benefits, education_requirement)
    VALUES ('$position_name', '$vacancy', '$deadline', '$experience_years', '$location', '$salary_range', '$job_type', '$qualifications', '$benefits', '$education_requirement')";

    if ($conn->query($sql) === TRUE) {
        header("Location: successful.html");
    } else {
        header("Location: error.html");
    }


    $conn->close();
}
