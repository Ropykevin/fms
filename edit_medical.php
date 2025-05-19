<?php
header('Content-Type: application/json');
$response = ['success' => false, 'message' => ''];

// Database connection
$con = mysqli_connect("localhost", "root", "", "fms");
if (!$con) {
    $response['message'] = "Database connection failed: " . mysqli_connect_error();
    echo json_encode($response);
    exit;
}

// Validate and sanitize input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $record_id = mysqli_real_escape_string($con, $_POST['record_id']);
    $animal_id = mysqli_real_escape_string($con, $_POST['animal_id']);
    $report_date = mysqli_real_escape_string($con, $_POST['report_date']);
    $diagnosis = mysqli_real_escape_string($con, $_POST['diagnosis']);
    $treatment = mysqli_real_escape_string($con, $_POST['treatment']);
    $medicine = mysqli_real_escape_string($con, $_POST['medicine']);
    $cost = floatval($_POST['cost']);

    // Validate required fields
    if (
        empty($record_id) || empty($animal_id) || empty($report_date) ||
        empty($diagnosis) || empty($treatment) || empty($medicine) || empty($cost)
    ) {
        $response['message'] = "All fields are required";
        echo json_encode($response);
        exit;
    }

    // Check if animal exists
    $check_query = "SELECT animal_id FROM livestock WHERE animal_id = '$animal_id'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) === 0) {
        $response['message'] = "Animal ID does not exist";
        echo json_encode($response);
        exit;
    }

    // Check if medical report exists
    $check_query = "SELECT record_id FROM medical_report WHERE record_id = '$record_id'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) === 0) {
        $response['message'] = "Medical report not found";
        echo json_encode($response);
        exit;
    }

    // Update the medical report
    $query = "UPDATE medical_report 
              SET animal_id = '$animal_id',
                  report_date = '$report_date',
                  diagnosis = '$diagnosis',
                  treatment = '$treatment',
                  medicine = '$medicine',
                  cost = $cost
              WHERE record_id = '$record_id'";

    if (mysqli_query($con, $query)) {
        $response['success'] = true;
        $response['message'] = "Medical report updated successfully";
    } else {
        $response['message'] = "Error updating medical report: " . mysqli_error($con);
    }
} else {
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
?>