<!DOCTYPE html>
<?php 
include('func1.php');
$con = mysqli_connect("localhost", "root", "", "fms");

// Check the database connection
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

$eid = $_SESSION['eid'];
$emp = $_SESSION['empname'];

/****************************************************
   PROCESSING FORM SUBMISSIONS – INSERT NEW DATA
****************************************************/

/* 1. Livestock Entry */
if (isset($_POST['livestock_sub'])) {
    $species  = mysqli_real_escape_string($con, $_POST['species']);
    $breed    = mysqli_real_escape_string($con, $_POST['breed']);
    $gender   = mysqli_real_escape_string($con, $_POST['gender']);
    $dob      = $_POST['dob'];
    $weight   = $_POST['weight'];
    $ear_tag  = mysqli_real_escape_string($con, $_POST['ear_tag']);
    $notes    = mysqli_real_escape_string($con, $_POST['notes']);
    
    // Validate weight is positive
    if ($weight > 0) {
        $query = "INSERT INTO livestock (species, breed, gender, date_of_birth, weight, ear_tag, notes) 
                  VALUES ('$species', '$breed', '$gender', '$dob', '$weight', '$ear_tag', '$notes')";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Livestock added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding livestock: " . mysqli_error($con) . "');</script>";
        }
    } else {
        echo "<script>alert('Weight must be positive.');</script>";
    }
}

/* 2. Livestock Deletion */
if (isset($_POST['livestock_sub1'])) {
    $ear_tag = mysqli_real_escape_string($con, $_POST['ear_tag']);
    $query = "DELETE FROM livestock WHERE ear_tag = '$ear_tag'";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Livestock removed successfully!');</script>";
    } else {
        echo "<script>alert('Error removing livestock: " . mysqli_error($con) . "');</script>";
    }
}

/* 3. Feeding Record Entry */
if (isset($_POST['feeding_sub'])) {
    $animal_id    = mysqli_real_escape_string($con, $_POST['animal_id']);
    $feeding_date = $_POST['feeding_date'];
    $feed_type    = mysqli_real_escape_string($con, $_POST['feed_type']);
    $quantity     = $_POST['quantity'];
    $remarks      = mysqli_real_escape_string($con, $_POST['remarks']);
    
    // Validate that quantity is positive
    if ($quantity > 0) {
        $query = "INSERT INTO feeding_report (animal_id, feeding_date, feed_type, quantity, remarks)
                  VALUES ('$animal_id', '$feeding_date', '$feed_type', '$quantity', '$remarks')";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Feeding record added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding feeding record: " . mysqli_error($con) . "');</script>";
        }
    } else {
        echo "<script>alert('Quantity must be positive.');</script>";
    }
}

/* 4. Produce Record Entry */
if (isset($_POST['produce_sub'])) {
    $animal_id    = mysqli_real_escape_string($con, $_POST['animal_id']);
    $report_date  = $_POST['report_date'];
    $produce_type = mysqli_real_escape_string($con, $_POST['produce_type']);
    $quantity     = $_POST['quantity'];
    $remarks      = mysqli_real_escape_string($con, $_POST['remarks']);
    
    if ($quantity > 0) {
        $query = "INSERT INTO produce_report (animal_id, report_date, produce_type, quantity, remarks)
                  VALUES ('$animal_id', '$report_date', '$produce_type', '$quantity', '$remarks')";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Produce record added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding produce record: " . mysqli_error($con) . "');</script>";
        }
    } else {
        echo "<script>alert('Quantity must be positive.');</script>";
    }
}

/* 5. Medical Record Entry */
if (isset($_POST['medical_sub'])) {
    $animal_id   = mysqli_real_escape_string($con, $_POST['animal_id']);
    $report_date = $_POST['report_date'];
    $diagnosis   = mysqli_real_escape_string($con, $_POST['diagnosis']);
    $treatment   = mysqli_real_escape_string($con, $_POST['treatment']);
    $medicine    = mysqli_real_escape_string($con, $_POST['medicine']);
    $cost        = $_POST['cost'];
    $vet_name    = mysqli_real_escape_string($con, $_POST['vet_name']);
    $remarks     = mysqli_real_escape_string($con, $_POST['remarks']);
    
    if ($cost >= 0) {
        $query = "INSERT INTO medical_report (animal_id, report_date, diagnosis, treatment, medicine, cost, vet_name, remarks)
                  VALUES ('$animal_id', '$report_date', '$diagnosis', '$treatment', '$medicine', '$cost', '$vet_name', '$remarks')";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Medical report added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding medical report: " . mysqli_error($con) . "');</script>";
        }
    } else {
        echo "<script>alert('Cost must be non-negative.');</script>";
    }
}
?>
<html lang="en">
<head>
    <title>UYOMA FARM MANAGEMENT SYSTEM</title>
    <link rel="shortcut icon" type="image/x-icon" href="logo.jpeg"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Include Bootstrap and other required styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    
    <style>
        /* Custom styles for the navigation and layout */
        .btn-outline-light:hover {
            color: #25bef7;
            background-color: #f8f9fa;
            border-color: #f8f9fa;
        }
        .bg-primary {
            background: -webkit-linear-gradient(left, #3931af, #00c6ff);
        }
        .list-group-item.active {
            z-index: 2;
            color: #fff;
            background-color: #342ac1;
            border-color: #007bff;
        }
        .text-primary {
            color: #342ac1!important;
        }
        button:hover, #inputbtn:hover {
            cursor: pointer;
        }
    </style>
</head>
<body style="padding-top:50px;">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i>UYOMA FARM MANAGEMENT SYSTEM</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout1.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="post" action="empsearch.php">
                <div class="col-md-10">
                    <input type="text" name="emp_contact" placeholder="Enter Email ID" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="submit" name="emp_search_submit" class="btn btn-primary" value="Search">
                </div>
            </form>
        </div>
    </nav>
    
    <!-- Main container for content and tab navigation -->
    <div class="container-fluid" style="margin-top:50px;">
        <h3 style="margin-left: 40%; padding-bottom: 20px; font-family:'IBM Plex Sans', sans-serif;">Welcome <?php echo $_SESSION['empname']; ?></h3>
        <div class="row">
            <div class="col-md-4" style="max-width:18%; margin-top: 3%;">
                <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active" href="#list-dash" role="tab" data-toggle="list">Dashboard</a>
                    <a class="list-group-item list-group-item-action" href="#list-livestock" id="list-livestock-list" role="tab" data-toggle="list">Livestock</a>
                    <a class="list-group-item list-group-item-action" href="#list-feeding" id="list-feeding-list" role="tab" data-toggle="list">Feeding Records</a>
                    <a class="list-group-item list-group-item-action" href="#list-medical" id="list-medical-list" role="tab" data-toggle="list">Medical Reports</a>
                    <a class="list-group-item list-group-item-action" href="#list-produce" id="list-produce-list" role="tab" data-toggle="list">Produce Reports</a>
                    
                    <!-- Data Entry Tabs -->
                    <a class="list-group-item list-group-item-action" href="#list-settings" id="list-settings-list" role="tab" data-toggle="list">Add Livestock</a>
                    <a class="list-group-item list-group-item-action" href="#list-settings1" id="list-settings1-list" role="tab" data-toggle="list">Delete Livestock</a>
                    <a class="list-group-item list-group-item-action" href="#list-feeding-record" id="list-feeding-record-list" role="tab" data-toggle="list">Add Feeding Record</a>
                    <a class="list-group-item list-group-item-action" href="#list-medical-record" id="list-medical-record-list" role="tab" data-toggle="list">Add Medical Report</a>
                    <a class="list-group-item list-group-item-action" href="#list-produce-record" id="list-produce-record-list" role="tab" data-toggle="list">Add Produce Record</a>
                </div>
                <br>
            </div>
            
            <div class="col-md-8" style="margin-top: 3%;">
                <div class="tab-content" id="nav-tabContent" style="width: 950px;">
                    <!-- Dashboard Tab -->
                    <div class="tab-pane fade show active" id="list-dash" role="tabpanel">
                        <div class="container-fluid bg-white">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="panel text-center">
                                        <div class="panel-body">
                                            <span class="fa-stack fa-2x">
                                                <i class="fa fa-square fa-stack-2x text-primary"></i>
                                                <i class="fa fa-paw fa-stack-1x fa-inverse"></i>
                                            </span>
                                            <h4 class="StepTitle" style="margin-top:5%;">View Livestock</h4>
                                            <p class="links">
                                                <a href="#list-livestock" onclick="document.querySelector('#list-livestock-list').click();">Livestock List</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- You may add additional dashboard panels here for Feeding, Medical, and Produce Reports -->
                            </div>
                        </div>
                    </div>
                    
                    <!-- Livestock List Tab -->
                    <div class="tab-pane fade" id="list-livestock" role="tabpanel">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Animal ID</th>
                                    <th>Species</th>
                                    <th>Breed</th>
                                    <th>Gender</th>
                                    <th>DOB</th>
                                    <th>Weight</th>
                                    <th>Ear Tag</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $query = "SELECT * FROM livestock";
                                $result = mysqli_query($con, $query);
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>
                                          <td>{$row['animal_id']}</td>
                                          <td>{$row['species']}</td>
                                          <td>{$row['breed']}</td>
                                          <td>{$row['gender']}</td>
                                          <td>{$row['date_of_birth']}</td>
                                          <td>{$row['weight']}</td>
                                          <td>{$row['ear_tag']}</td>
                                          <td>{$row['notes']}</td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Feeding Records Tab -->
                    <div class="tab-pane fade" id="list-feeding" role="tabpanel">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Report ID</th>
                                    <th>Animal ID</th>
                                    <th>Feeding Date</th>
                                    <th>Feed Type</th>
                                    <th>Quantity</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $query = "SELECT * FROM feeding_report";
                                $result = mysqli_query($con, $query);
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>
                                          <td>{$row['report_id']}</td>
                                          <td>{$row['animal_id']}</td>
                                          <td>{$row['feeding_date']}</td>
                                          <td>{$row['feed_type']}</td>
                                          <td>{$row['quantity']}</td>
                                          <td>{$row['remarks']}</td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Medical Reports Tab -->
                    <div class="tab-pane fade" id="list-medical" role="tabpanel">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Record ID</th>
                                    <th>Animal ID</th>
                                    <th>Report Date</th>
                                    <th>Diagnosis</th>
                                    <th>Treatment</th>
                                    <th>Medicine</th>
                                    <th>Cost</th>
                                    <th>Vet Name</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $query = "SELECT * FROM medical_report";
                                $result = mysqli_query($con, $query);
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>
                                          <td>{$row['record_id']}</td>
                                          <td>{$row['animal_id']}</td>
                                          <td>{$row['report_date']}</td>
                                          <td>{$row['diagnosis']}</td>
                                          <td>{$row['treatment']}</td>
                                          <td>{$row['medicine']}</td>
                                          <td>{$row['cost']}</td>
                                          <td>{$row['vet_name']}</td>
                                          <td>{$row['remarks']}</td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Produce Reports Tab -->
                    <div class="tab-pane fade" id="list-produce" role="tabpanel">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Report ID</th>
                                    <th>Animal ID</th>
                                    <th>Report Date</th>
                                    <th>Produce Type</th>
                                    <th>Quantity</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $query = "SELECT * FROM produce_report";
                                $result = mysqli_query($con, $query);
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>
                                          <td>{$row['report_id']}</td>
                                          <td>{$row['animal_id']}</td>
                                          <td>{$row['report_date']}</td>
                                          <td>{$row['produce_type']}</td>
                                          <td>{$row['quantity']}</td>
                                          <td>{$row['remarks']}</td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Data Entry Forms -->
                    <!-- 1. Add Livestock Form -->
                    <div class="tab-pane fade" id="list-settings" role="tabpanel">
                        <form class="form-group" method="post" action="employee.php">
                            <div class="row">
                                <div class="col-md-4"><label>Species:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="species" required></div>
                                <div class="col-md-4"><label>Breed:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="breed" required></div>
                                <div class="col-md-4"><label>Gender:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="gender" required></div>
                                <div class="col-md-4"><label>Date of Birth:</label></div>
                                <div class="col-md-8"><input type="date" class="form-control" name="dob" required></div>
                                <div class="col-md-4"><label>Weight (kg):</label></div>
                                <div class="col-md-8"><input type="number" class="form-control" name="weight" required></div>
                                <div class="col-md-4"><label>Ear Tag:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="ear_tag" required></div>
                                <div class="col-md-4"><label>Notes:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="notes"></div>
                            </div>
                            <input type="submit" name="livestock_sub" value="Add Livestock" class="btn btn-primary">
                        </form>
                    </div>
                    
                    <!-- 2. Delete Livestock Form -->
                    <div class="tab-pane fade" id="list-settings1" role="tabpanel">
                        <form class="form-group" method="post" action="employee.php">
                            <div class="row">
                                <div class="col-md-4"><label>Ear Tag:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="ear_tag" required></div>
                            </div>
                            <input type="submit" name="livestock_sub1" value="Delete Livestock" class="btn btn-primary" onclick="return confirm('Do you really want to delete?');">
                        </form>
                    </div>
                    
                    <!-- 3. Add Feeding Record Form -->
                    <div class="tab-pane fade" id="list-feeding-record" role="tabpanel">
                        <form class="form-group" method="post" action="employee.php">
                            <div class="row">
                                <div class="col-md-4"><label>Animal ID:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="animal_id" required></div>
                                <div class="col-md-4"><label>Feeding Date:</label></div>
                                <div class="col-md-8"><input type="date" class="form-control" name="feeding_date" required></div>
                                <div class="col-md-4"><label>Feed Type:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="feed_type" required></div>
                                <div class="col-md-4"><label>Quantity:</label></div>
                                <div class="col-md-8"><input type="number" class="form-control" name="quantity" required></div>
                                <div class="col-md-4"><label>Remarks:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="remarks"></div>
                            </div>
                            <input type="submit" name="feeding_sub" value="Add Feeding Record" class="btn btn-primary">
                        </form>
                    </div>
                    
                    <!-- 4. Add Medical Report Form -->
                    <div class="tab-pane fade" id="list-medical-record" role="tabpanel">
                        <form class="form-group" method="post" action="employee.php">
                            <div class="row">
                                <div class="col-md-4"><label>Animal ID:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="animal_id" required></div>
                                <div class="col-md-4"><label>Report Date:</label></div>
                                <div class="col-md-8"><input type="date" class="form-control" name="report_date" required></div>
                                <div class="col-md-4"><label>Diagnosis:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="diagnosis" required></div>
                                <div class="col-md-4"><label>Treatment:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="treatment" required></div>
                                <div class="col-md-4"><label>Medicine:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="medicine" required></div>
                                <div class="col-md-4"><label>Cost:</label></div>
                                <div class="col-md-8"><input type="number" class="form-control" name="cost" required></div>
                                <div class="col-md-4"><label>Vet Name:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="vet_name" required></div>
                                <div class="col-md-4"><label>Remarks:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="remarks"></div>
                            </div>
                            <input type="submit" name="medical_sub" value="Add Medical Report" class="btn btn-primary">
                        </form>
                    </div>
                    
                    <!-- 5. Add Produce Record Form -->
                    <div class="tab-pane fade" id="list-produce-record" role="tabpanel">
                        <form class="form-group" method="post" action="employee.php">
                            <div class="row">
                                <div class="col-md-4"><label>Animal ID:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="animal_id" required></div>
                                <div class="col-md-4"><label>Report Date:</label></div>
                                <div class="col-md-8"><input type="date" class="form-control" name="report_date" required></div>
                                <div class="col-md-4"><label>Produce Type:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="produce_type" required></div>
                                <div class="col-md-4"><label>Quantity:</label></div>
                                <div class="col-md-8"><input type="number" class="form-control" name="quantity" required></div>
                                <div class="col-md-4"><label>Remarks:</label></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="remarks"></div>
                            </div>
                            <input type="submit" name="produce_sub" value="Add Produce Record" class="btn btn-primary">
                        </form>
                    </div>
                    
                    <!-- Optionally, a Bill Generation Form can be added here -->
                    
                </div>
            </div>
        </div>
    </div>
    
    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" 
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" 
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" 
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" 
            integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" 
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js"></script>
</body>
</html>