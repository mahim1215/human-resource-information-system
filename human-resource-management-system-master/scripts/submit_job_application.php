<?php

include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $job_id = $_POST['job_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $salary_expectation = $_POST['salary_expectation'];

    $cv = $_FILES['cv']['name'];
    $cv_tmp = $_FILES['cv']['tmp_name'];
    $uploads_dir = 'uploads';

    // Create uploads directory if it doesn't exist
    if (!file_exists($uploads_dir)) {
        mkdir($uploads_dir, 0777, true); // Creates the directory with write permissions
    }

    $cv_folder = $uploads_dir . '/' . $cv;

    if (move_uploaded_file($cv_tmp, $cv_folder)) {
        $sql = "INSERT INTO applicants (job_id, name, email, gender, address, salary_expectation, cv_path)
                VALUES ('$job_id', '$name', '$email', '$gender', '$address', '$salary_expectation', '$cv_folder')";

        if ($conn->query($sql) === TRUE) {
            echo "Application submitted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Failed to upload CV";
    }

    $conn->close();
}
