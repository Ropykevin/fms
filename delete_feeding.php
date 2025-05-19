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
    $report_id = mysqli_real_escape_string($con, $_POST['report_id']);

    // Check if feeding report exists
    $check_query = "SELECT report_id FROM feeding_report WHERE report_id = '$report_id'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) === 0) {
        $response['message'] = "Feeding report not found";
        echo json_encode($response);
        exit;
    }

    // Delete the feeding report
    $query = "DELETE FROM feeding_report WHERE report_id = '$report_id'";
    if (mysqli_query($con, $query)) {
        $response['success'] = true;
        $response['message'] = "Feeding report deleted successfully";
    } else {
        $response['message'] = "Error deleting feeding report: " . mysqli_error($con);
    }
} else {
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
?>