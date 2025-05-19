<?php
header('Content-Type: application/json');
$response = ['success' => false, 'message' => '', 'feeding' => null];

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

// Fetch the feeding report
$query = "SELECT * FROM feeding_report WHERE report_id = '$report_id'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $feeding = mysqli_fetch_assoc($result);
    $response['success'] = true;
    $response['feeding'] = $feeding;
} else {
    $response['message'] = "Feeding report not found";
}

echo json_encode($response);
?>