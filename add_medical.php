<?php
header('Content-Type: application/json');
$response = ['success' => false, 'message' => ''];

// Database connection
// mysqli_connect('db', 'farmappuser', 'farmappsecret', 'farmappdb');
mysqli_connect('db', 'farmappuser', 'farmappsecret', 'farmappdb');

if (!$con) {
    $response['message'] = "Database connection failed: " . mysqli_connect_error();
    echo json_encode($response);
    exit;
}

// Validate and sanitize input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animal_id = mysqli_real_escape_string($con, $_POST['animal_id']);
    $report_date = mysqli_real_escape_string($con, $_POST['report_date']);
    $diagnosis = mysqli_real_escape_string($con, $_POST['diagnosis']);
    $treatment = mysqli_real_escape_string($con, $_POST['treatment']);
    $medicine = mysqli_real_escape_string($con, $_POST['medicine']);
    $cost = floatval($_POST['cost']);

    // Validate required fields
    if (
        empty($animal_id) || empty($report_date) || empty($diagnosis) ||
        empty($treatment) || empty($medicine) || empty($cost)
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

    // Insert the new medical report
    $query = "INSERT INTO medical_report (animal_id, report_date, diagnosis, treatment, medicine, cost) 
              VALUES ('$animal_id', '$report_date', '$diagnosis', '$treatment', '$medicine', $cost)";

    if (mysqli_query($con, $query)) {
        $response['success'] = true;
        $response['message'] = "Medical report added successfully";
    } else {
        $response['message'] = "Error adding medical report: " . mysqli_error($con);
    }
} else {
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
mysqli_close($con);
?>