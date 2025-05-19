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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $record_id = mysqli_real_escape_string($con, $_POST['record_id']);

    // Check if medical report exists
    $check_query = "SELECT record_id FROM medical_report WHERE record_id = '$record_id'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) === 0) {
        $response['message'] = "Medical report not found";
        echo json_encode($response);
        exit;
    }

    // Delete the medical report
    $query = "DELETE FROM medical_report WHERE record_id = '$record_id'";
    if (mysqli_query($con, $query)) {
        $response['success'] = true;
        $response['message'] = "Medical report deleted successfully";
    } else {
        $response['message'] = "Error deleting medical report: " . mysqli_error($con);
    }
} else {
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
?>