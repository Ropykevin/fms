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

    // Check if produce report exists
    $check_query = "SELECT report_id FROM produce_report WHERE report_id = '$report_id'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) === 0) {
        $response['message'] = "Produce report not found";
        echo json_encode($response);
        exit;
    }

    // Delete the produce report
    $query = "DELETE FROM produce_report WHERE report_id = '$report_id'";
    if (mysqli_query($con, $query)) {
        $response['success'] = true;
        $response['message'] = "Produce report deleted successfully";
    } else {
        $response['message'] = "Error deleting produce report: " . mysqli_error($con);
    }
} else {
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
?>