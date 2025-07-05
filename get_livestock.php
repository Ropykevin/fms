<?php
header('Content-Type: application/json');

// Database connection
$con = mysqli_connect("localhost", "root", "", "fms");

if (!$con) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

if (isset($_GET['animal_id'])) {
    $animal_id = mysqli_real_escape_string($con, $_GET['animal_id']);
    
    $query = "SELECT * FROM livestock WHERE animal_id = '$animal_id'";
    $result = mysqli_query($con, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $livestock = mysqli_fetch_assoc($result);
        echo json_encode(['success' => true, 'livestock' => $livestock]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Livestock not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Animal ID is required']);
}

mysqli_close($con);
?> 