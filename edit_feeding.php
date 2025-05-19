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
    $report_id = mysqli_real_escape_string($con, $_POST['report_id']);
    $animal_id = mysqli_real_escape_string($con, $_POST['animal_id']);
    $feeding_date = mysqli_real_escape_string($con, $_POST['feeding_date']);
    $feed_type = mysqli_real_escape_string($con, $_POST['feed_type']);
    $quantity = floatval($_POST['quantity']);
    $remarks = mysqli_real_escape_string($con, $_POST['remarks']);

    // Validate required fields
    if (empty($report_id) || empty($animal_id) || empty($feeding_date) || empty($feed_type) || empty($quantity)) {
        $response['message'] = "All fields except remarks are required";
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

    // Check if feeding report exists
    $check_query = "SELECT report_id FROM feeding_report WHERE report_id = '$report_id'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) === 0) {
        $response['message'] = "Feeding report not found";
        echo json_encode($response);
        exit;
    }

    // Update the feeding report
    $query = "UPDATE feeding_report 
              SET animal_id = '$animal_id',
                  feeding_date = '$feeding_date',
                  feed_type = '$feed_type',
                  quantity = $quantity,
                  remarks = '$remarks'
              WHERE report_id = '$report_id'";

    if (mysqli_query($con, $query)) {
        $response['success'] = true;
        $response['message'] = "Feeding report updated successfully";
    } else {
        $response['message'] = "Error updating feeding report: " . mysqli_error($con);
    }
} else {
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
?>