<?php
function getConnection()
{
    $con = mysqli_connect("localhost", "root", "", "fms");
    if (!$con) {
        error_log("Database connection failed: " . mysqli_connect_error());
        return false;
    }
    return $con;
}
?>