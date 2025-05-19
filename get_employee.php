<?php
header('Content-Type: application/json');
$response = ['success' => false, 'message' => '', 'employee' => null];

// Database connection
$con = mysqli_connect("localhost", "root", "", "fms");
if (!$con) {
    $response['message'] = "Database connection failed: " . mysqli_connect_error();
    echo json_encode($response);
    exit;
}

// Validate input
if (!isset($_GET['email']) || empty($_GET['email'])) {
    $response['message'] = "Email is required";
    echo json_encode($response);
    exit;
}

$email = mysqli_real_escape_string($con, $_GET['email']);

// Fetch the employee data
$query = "SELECT username, email, phone, salary FROM emptb WHERE email = '$email'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $employee = mysqli_fetch_assoc($result);
    $response['success'] = true;
    $response['employee'] = $employee;
} else {
    $response['message'] = "Employee not found";
}

echo json_encode($response);
?>