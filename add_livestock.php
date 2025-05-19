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

// Validate and sanitize input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animal_id = mysqli_real_escape_string($con, $_POST['animal_id']);
    $species = mysqli_real_escape_string($con, $_POST['species']);
    $breed = mysqli_real_escape_string($con, $_POST['breed']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $date_of_birth = mysqli_real_escape_string($con, $_POST['date_of_birth']);
    $weight = floatval($_POST['weight']);
    $ear_tag = mysqli_real_escape_string($con, $_POST['ear_tag']);

    // Validate required fields
    if (
        empty($animal_id) || empty($species) || empty($breed) || empty($gender) ||
        empty($date_of_birth) || empty($weight) || empty($ear_tag)
    ) {
        $response['message'] = "All fields are required";
        echo json_encode($response);
        exit;
    }

    // Check if animal_id already exists
    $check_query = "SELECT animal_id FROM livestock WHERE animal_id = '$animal_id'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $response['message'] = "Animal ID already exists";
        echo json_encode($response);
        exit;
    }

    // Insert the new livestock record
    $query = "INSERT INTO livestock (animal_id, species, breed, gender, date_of_birth, weight, ear_tag) 
              VALUES ('$animal_id', '$species', '$breed', '$gender', '$date_of_birth', $weight, '$ear_tag')";

    if (mysqli_query($con, $query)) {
        $response['success'] = true;
        $response['message'] = "Livestock added successfully";
    } else {
        $response['message'] = "Error adding livestock: " . mysqli_error($con);
    }
} else {
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
mysqli_close($con);
?>