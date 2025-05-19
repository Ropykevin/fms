<?php
header('Content-Type: application/json');
$response = ['success' => false, 'message' => '', 'produce' => null];

// Database connection
$con = mysqli_connect("localhost", "root", "", "fms");
if (!$con) {
    $response['message'] = "Database connection failed: " . mysqli_connect_error();
    echo json_encode($response);
    exit;
}

// Validate input
if (!isset($_GET['report_id']) || empty($_GET['report_id'])) {
    $response['message'] = "Report ID is required";
    echo json_encode($response);
    exit;
}

$report_id = mysqli_real_escape_string($con, $_GET['report_id']);

// Fetch the produce report
$query = "SELECT * FROM produce_report WHERE report_id = '$report_id'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $produce = mysqli_fetch_assoc($result);
    $response['success'] = true;
    $response['produce'] = $produce;
} else {
    $response['message'] = "Produce report not found";
}

echo json_encode($response);
?>