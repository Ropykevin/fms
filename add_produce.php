<?php
header('Content-Type: application/json');
$response = ['success' => false, 'message' => ''];

require_once 'mail_functions.php';

// Database connection
$con = mysqli_connect("localhost", "root", "", "fms");

if (!$con) {
    $response['message'] = "Database connection failed: " . mysqli_connect_error();
    echo json_encode($response);
    exit;
}

// Validate and sanitize input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animal_id = mysqli_real_escape_string($con, $_POST['animal_id']);
    $report_date = mysqli_real_escape_string($con, $_POST['report_date']);
    $produce_type = mysqli_real_escape_string($con, $_POST['produce_type']);
    $quantity = floatval($_POST['quantity']);
    $remarks = mysqli_real_escape_string($con, $_POST['remarks']);

    // Validate required fields
    if (empty($animal_id) || empty($report_date) || empty($produce_type) || empty($quantity)) {
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

    // Insert the new produce report
    $query = "INSERT INTO produce_report (animal_id, report_date, produce_type, quantity, remarks) 
              VALUES ('$animal_id', '$report_date', '$produce_type', $quantity, '$remarks')";

    if (mysqli_query($con, $query)) {
        $report_id = mysqli_insert_id($con);

        // Prepare report data for email
        $reportData = [
            'Report ID' => $report_id,
            'Animal ID' => $animal_id,
            'Report Date' => $report_date,
            'Produce Type' => $produce_type,
            'Quantity' => $quantity,
            'Remarks' => $remarks
        ];

        // Send email notification
        if (sendReportNotification('Produce', $reportData)) {
            $response['success'] = true;
            $response['message'] = "Produce report added successfully and admin notified";
        } else {
            $response['success'] = true;
            $response['message'] = "Produce report added successfully but admin notification failed";
        }
    } else {
        $response['message'] = "Error adding produce report: " . mysqli_error($con);
    }
} else {
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
mysqli_close($con);
?>