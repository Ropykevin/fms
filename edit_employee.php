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
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $salary = floatval($_POST['salary']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate required fields
    if (empty($email) || empty($username) || empty($phone) || empty($salary)) {
        $response['message'] = "All fields except password are required";
        echo json_encode($response);
        exit;
    }

    // Validate phone number format
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        $response['message'] = "Invalid phone number format";
        echo json_encode($response);
        exit;
    }

    // Check if employee exists
    $check_query = "SELECT email FROM emptb WHERE email = '$email'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) === 0) {
        $response['message'] = "Employee not found";
        echo json_encode($response);
        exit;
    }

    // Check if new email is already taken by another employee
    if ($email !== $_POST['email']) {
        $check_query = "SELECT email FROM emptb WHERE email = '$email' AND email != '{$_POST['email']}'";
        $check_result = mysqli_query($con, $check_query);
        if (mysqli_num_rows($check_result) > 0) {
            $response['message'] = "Email is already taken by another employee";
            echo json_encode($response);
            exit;
        }
    }

    // Build the update query
    $query = "UPDATE emptb SET 
              username = '$username',
              phone = '$phone',
              salary = $salary";

    // Add password update if provided
    if (!empty($password)) {
        if ($password !== $confirm_password) {
            $response['message'] = "Passwords do not match";
            echo json_encode($response);
            exit;
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query .= ", password = '$hashed_password'";
    }

    $query .= " WHERE email = '{$_POST['email']}'";

    if (mysqli_query($con, $query)) {
        $response['success'] = true;
        $response['message'] = "Employee updated successfully";
    } else {
        $response['message'] = "Error updating employee: " . mysqli_error($con);
    }
} else {
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
?>