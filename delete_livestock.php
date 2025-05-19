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
    $animal_id = mysqli_real_escape_string($con, $_POST['animal_id']);

    // Check if livestock exists
    $check_query = "SELECT animal_id FROM livestock WHERE animal_id = '$animal_id'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) === 0) {
        $response['message'] = "Livestock not found";
        echo json_encode($response);
        exit;
    }

    // Delete related records first
    mysqli_query($con, "DELETE FROM feeding_report WHERE animal_id = '$animal_id'");
    mysqli_query($con, "DELETE FROM medical_report WHERE animal_id = '$animal_id'");
    mysqli_query($con, "DELETE FROM produce_report WHERE animal_id = '$animal_id'");

    // Delete the livestock record
    $query = "DELETE FROM livestock WHERE animal_id = '$animal_id'";
    if (mysqli_query($con, $query)) {
        $response['success'] = true;
        $response['message'] = "Livestock deleted successfully";
    } else {
        $response['message'] = "Error deleting livestock: " . mysqli_error($con);
    }
} else {
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
?>