<?php
header('Content-Type: application/json');
$response = ['success' => false, 'message' => '', 'medical' => null];

// Database connection
$con = mysqli_connect("localhost", "root", "", "fms");
if (!$con) {
    $response['message'] = "Database connection failed: " . mysqli_connect_error();
    echo json_encode($response);
    exit;
}

// Validate input
if (!isset($_GET['record_id']) || empty($_GET['record_id'])) {
    $response['message'] = "Record ID is required";
    echo json_encode($response);
    exit;
}

$record_id = mysqli_real_escape_string($con, $_GET['record_id']);

// Fetch the medical report
$query = "SELECT * FROM medical_report WHERE record_id = '$record_id'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $medical = mysqli_fetch_assoc($result);
    $response['success'] = true;
    $response['medical'] = $medical;
} else {
    $response['message'] = "Medical report not found";
}

echo json_encode($response);
?>