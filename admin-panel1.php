<!DOCTYPE html>
<?php
$con = mysqli_connect("localhost", "root", "", "fms");

include('newfunc.php');

if (isset($_POST['empsub'])) {
  $emp = $_POST['emp'];
  $emppassword = $_POST['emppassword'];
  $empemail = $_POST['empemail'];
  $phone = $_POST['phone'];
  $salary = $_POST['salary'];
  $query = "insert into emptb(username,password,email,phone,salary)values('$emp','$emppassword','$empemail','$phone','$salary')";
  $result = mysqli_query($con, $query);
  if ($result) {
    echo "<script>alert('Employee added successfully!');</script>";
  }
}


if (isset($_POST['empsub1'])) {
  $empemail = mysqli_real_escape_string($con, $_POST['empemail']);

  // First verify the employee exists
  $check_query = "SELECT username FROM emptb WHERE email = '$empemail'";
  $check_result = mysqli_query($con, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    $row = mysqli_fetch_array($check_result);
    $username = $row['username'];

    // Proceed with deletion
    $query = "DELETE FROM emptb WHERE email = '$empemail'";
    $result = mysqli_query($con, $query);

    if ($result) {
      echo "<script>
        alert('Employee " . addslashes($username) . " has been successfully deleted!');
        window.location.href = 'admin-panel1.php#delete-emp-content';
      </script>";
    } else {
      echo "<script>
        alert('Error deleting employee. Please try again.');
        window.location.href = 'admin-panel1.php#delete-emp-content';
      </script>";
    }
  } else {
    echo "<script>
      alert('Employee not found!');
      window.location.href = 'admin-panel1.php#delete-emp-content';
    </script>";
  }
}

?>
<html lang="en">

<head>

  <title>UYOMA FARM MANAGEMENT SYSTEM</title>
  <link rel="shortcut icon" type="image/x-icon" href="logo.jpeg" />
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">

  <style>
    .bg-primary {
      background: -webkit-linear-gradient(left, red, green);
    }

    .col-md-4 {
      max-width: 20% !important;
    }

    .list-group-item.active {
      z-index: 2;
      color: #fff;
      background-color: #342ac1;
      border-color: #007bff;
    }

    .text-primary {
      color: black !important;
    }

    #cpass {
      display: -webkit-box;
    }

    #list-app {
      font-size: 15px;
    }

    .btn-primary {
      background-color: #3c50c1;
      border-color: #3c50c1;
    }

    .panel-body a {
      display: inline-block;
      padding: 8px 15px;
      color: #007bff;
      text-decoration: none;
      cursor: pointer;
      position: relative;
      z-index: 1;
    }

    .panel-body a:hover {
      color: #0056b3;
      text-decoration: underline;
    }

    .panel {
      position: relative;
      cursor: pointer;
    }

    .panel-body {
      position: relative;
      z-index: 1;
    }

    .links.cl-effect-1 a,
    .cl-effect-1 a {
      position: relative;
      display: inline-block;
      margin: 15px 0;
      padding: 6px 20px;
      color: #007bff;
      text-decoration: none;
      text-transform: uppercase;
      letter-spacing: 1px;
      overflow: hidden;
      border: 2px solid #007bff;
      border-radius: 4px;
    }

    .links.cl-effect-1 a:hover,
    .cl-effect-1 a:hover {
      color: #fff;
      background: #007bff;
    }

    .form-select {
      padding: 0.5rem;
      border: 1px solid #ced4da;
      border-radius: 0.25rem;
      width: 100%;
    }

    .card {
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      border: none;
      margin-bottom: 1rem;
    }

    .card-header {
      background-color: #f8f9fa;
      border-bottom: 1px solid #e9ecef;
    }

    .table-responsive {
      margin-top: 1rem;
    }

    .btn-danger {
      padding: 0.5rem 1rem;
      font-weight: 500;
    }

    .btn-danger:hover {
      background-color: #dc3545;
      border-color: #dc3545;
    }
  </style>
</head>
<style type="text/css">
  button:hover {
    cursor: pointer;
  }

  #inputbtn:hover {
    cursor: pointer;
  }
</style>

<body style="padding-top:50px;">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <i class="fas fa-user-plus me-2"></i>UYOMA FARM MANAGEMENT SYSTEM
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="logout1.php">
              <i class="fas fa-sign-out-alt me-1"></i>Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <h3 style="margin-left: 40%; padding-bottom: 20px;font-family: 'IBM Plex Sans', sans-serif;"> WELCOME ADMIN
  </h3>


  <div class="container-fluid" style="margin-top:50px;">
    <div class="row">
      <!-- Sidebar Navigation -->
      <div class="col-lg-3 col-md-12  mb-4">
        <div class="list-group" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <a class="list-group-item list-group-item-action active" id="dash-tab" data-bs-toggle="pill"
            href="#dash-content" role="tab" aria-controls="dash-content" aria-selected="true">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
          </a>
          <a class="list-group-item list-group-item-action" id="emp-tab" data-bs-toggle="pill" href="#emp-content"
            role="tab" aria-controls="emp-content" aria-selected="false">
            <i class="fas fa-users me-2"></i>Employee List
          </a>
          <a class="list-group-item list-group-item-action" id="user-tab" data-bs-toggle="pill" href="#user-content"
            role="tab" aria-controls="user-content" aria-selected="false">
            <i class="fas fa-user me-2"></i>User List
          </a>
          <a class="list-group-item list-group-item-action" id="livestock-tab" data-bs-toggle="pill"
            href="#livestock-content" role="tab" aria-controls="livestock-content" aria-selected="false">
            <i class="fas fa-cow me-2"></i>Livestock List
          </a>
          <a class="list-group-item list-group-item-action" id="feeding-tab" data-bs-toggle="pill"
            href="#feeding-content" role="tab" aria-controls="feeding-content" aria-selected="false">
            <i class="fas fa-utensils me-2"></i>Feeding Reports
          </a>
          <a class="list-group-item list-group-item-action" id="medical-tab" data-bs-toggle="pill"
            href="#medical-content" role="tab" aria-controls="medical-content" aria-selected="false">
            <i class="fas fa-stethoscope me-2"></i>Medical Reports
          </a>
          <a class="list-group-item list-group-item-action" id="produce-tab" data-bs-toggle="pill"
            href="#produce-content" role="tab" aria-controls="produce-content" aria-selected="false">
            <i class="fas fa-seedling me-2"></i>Produce Reports
          </a>
          <a class="list-group-item list-group-item-action" id="add-emp-tab" data-bs-toggle="pill"
            href="#add-emp-content" role="tab" aria-controls="add-emp-content" aria-selected="false">
            <i class="fas fa-user-plus me-2"></i>Add Employee
          </a>
          <a class="list-group-item list-group-item-action" id="delete-emp-tab" data-bs-toggle="pill"
            href="#delete-emp-content" role="tab" aria-controls="delete-emp-content" aria-selected="false">
            <i class="fas fa-user-minus me-2"></i>Delete Employee
          </a>
          <a class="list-group-item list-group-item-action" id="queries-tab" data-bs-toggle="pill"
            href="#queries-content" role="tab" aria-controls="queries-content" aria-selected="false">
            <i class="fas fa-chart-bar me-2"></i>Queries
          </a>
          <a class="list-group-item list-group-item-action" id="reports-tab" data-bs-toggle="pill"
            href="#reports-content" role="tab" aria-controls="reports-content" aria-selected="false">
            <i class="fas fa-file-alt me-2"></i>Generate Reports
          </a>
        </div>
      </div>

      <!-- Tab Content -->
      <div class="col-lg-9 col-md-8">
        <div class="tab-content fade-in" id="v-pills-tabContent">
          <div class="tab-pane fade show active" id="dash-content" role="tabpanel" aria-labelledby="dash-tab">
            <div class="container-fluid p-0">
              <h4 class="mb-4">Dashboard Overview</h4>
              <div class="row g-3 mb-4">
                <div class="col-xl-4 col-md-6">
                  <div class="stats-card">
                    <h5 class="title">Total Employees</h5>
                    <?php
                    $query = "SELECT COUNT(*) as count FROM emptb";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_array($result);
                    echo '<h2 class="value">' . $row['count'] . '</h2>';
                    ?>
                  </div>
                </div>
                <div class="col-xl-4 col-md-6">
                  <div class="stats-card">
                    <h5 class="title">Total Livestock</h5>
                    <?php
                    $query = "SELECT COUNT(*) as count FROM livestock";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_array($result);
                    echo '<h2 class="value">' . $row['count'] . '</h2>';
                    ?>
                  </div>
                </div>
                <div class="col-xl-4 col-md-6">
                  <div class="stats-card">
                    <h5 class="title">Total Reports</h5>
                    <?php
                    $query = "SELECT 
                      (SELECT COUNT(*) FROM feeding_report) +
                      (SELECT COUNT(*) FROM medical_report) +
                      (SELECT COUNT(*) FROM produce_report) as total";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_array($result);
                    echo '<h2 class="value">' . $row['total'] . '</h2>';
                    ?>
                  </div>
                </div>
              </div>

              <!-- Existing dashboard cards with improved styling -->
              <div class="container-fluid container-fullw bg-white">
                <div class="row">
                  <div class="col-sm-4">
                    <div class="panel panel-white no-radius text-center">
                      <div class="panel-body">
                        <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i
                            class="fa fa-users fa-stack-1x fa-inverse"></i> </span>
                        <h4 class="StepTitle" style="margin-top: 5%;">Employee List</h4>
                        <p class="links cl-effect-1">
                          <a href="javascript:void(0)" onclick="activateTab('emp-content')" class="dashboard-link">
                            View Employee
                          </a>
                        </p>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-4" style="left: -3%">
                    <div class="panel panel-white no-radius text-center">
                      <div class="panel-body">
                        <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i
                            class="fa fa-users fa-stack-1x fa-inverse"></i> </span>
                        <h4 class="StepTitle" style="margin-top: 5%;">User List</h4>

                        <p class="cl-effect-1">
                          <a href="javascript:void(0)" onclick="activateTab('user-content')" class="dashboard-link">
                            View Users
                          </a>
                        </p>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="panel panel-white no-radius text-center">
                      <div class="panel-body">
                        <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i
                            class="fa fa-paw fa-stack-1x fa-inverse"></i> </span>
                        <h4 class="StepTitle" style="margin-top: 5%;">Livestock List</h4>

                        <p class="cl-effect-1">
                          <a href="javascript:void(0)" onclick="activateTab('livestock-content')"
                            class="dashboard-link">
                            View Livestock
                          </a>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-4">
                    <div class="panel panel-white no-radius text-center">
                      <div class="panel-body">
                        <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i
                            class="fa fa-cutlery fa-stack-1x fa-inverse"></i> </span>
                        <h4 class="StepTitle" style="margin-top: 5%;">Feeding Reports</h4>

                        <p class="cl-effect-1">
                          <a href="javascript:void(0)" onclick="activateTab('feeding-content')" class="dashboard-link">
                            View Feeding Reports
                          </a>
                        </p>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-4" style="left: -3%">
                    <div class="panel panel-white no-radius text-center">
                      <div class="panel-body">
                        <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i
                            class="fa fa-stethoscope fa-stack-1x fa-inverse"></i> </span>
                        <h4 class="StepTitle" style="margin-top: 5%;">Medical Reports</h4>

                        <p class="cl-effect-1">
                          <a href="javascript:void(0)" onclick="activateTab('medical-content')" class="dashboard-link">
                            View Medical Reports
                          </a>
                        </p>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="panel panel-white no-radius text-center">
                      <div class="panel-body">
                        <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i
                            class="fa fa-leaf fa-stack-1x fa-inverse"></i> </span>
                        <h4 class="StepTitle" style="margin-top: 5%;">Produce Reports</h4>

                        <p class="cl-effect-1">
                          <a href="javascript:void(0)" onclick="activateTab('produce-content')" class="dashboard-link">
                            View Produce Reports
                          </a>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="emp-content" role="tabpanel" aria-labelledby="emp-tab">
            <div class="container-fluid">
              <div class="row mb-4">
                <div class="col-md-8">
                  <h4>Employee List</h4>
                  <div class="card">
                    <div class="card-body">
                      <form class="form-group mb-4" action="empsearch.php" method="post">
                        <div class="input-group">
                          <input type="text" name="emp_contact" class="form-control" placeholder="Search by Email ID">
                          <button type="submit" name="emp_search_submit" class="btn btn-primary">
                            <i class="fa fa-search"></i> Search
                          </button>
                        </div>
                      </form>
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                          <thead class="table-light">
                            <tr>
                              <th>Employee Name</th>
                              <th>Email</th>
                              <th>Phone</th>
                              <th>Salary</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $query = "SELECT * FROM emptb ORDER BY username";
                            $result = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_array($result)) {
                              echo "<tr>
                                    <td>" . htmlspecialchars($row['username']) . "</td>
                                    <td>" . htmlspecialchars($row['email']) . "</td>
                                    <td>" . htmlspecialchars($row['phone']) . "</td>
                                    <td>" . htmlspecialchars($row['salary']) . "</td>
                                    <td>
                                      <button class='btn btn-sm btn-info' onclick='viewEmployee(\"" . htmlspecialchars($row['email']) . "\")'>
                                        <i class='fa fa-eye'></i>
                                      </button>
                                    </td>
                                  </tr>";
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="user-content" role="tabpanel" aria-labelledby="user-tab">
            <div class="container-fluid">
              <div class="row mb-4">
                <div class="col-md-12">
                  <h4>User List</h4>
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                          <thead class="table-light">
                            <tr>
                              <th>Animal ID</th>
                              <th>Species</th>
                              <th>Breed</th>
                              <th>Gender</th>
                              <th>Date of Birth</th>
                              <th>Weight (kg)</th>
                              <th>Ear Tag</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $query = "SELECT * FROM livestock ORDER BY animal_id";
                            $result = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_array($result)) {
                              echo "<tr>
                                    <td>" . htmlspecialchars($row['animal_id']) . "</td>
                                    <td>" . htmlspecialchars($row['species']) . "</td>
                                    <td>" . htmlspecialchars($row['breed']) . "</td>
                                    <td>" . htmlspecialchars($row['gender']) . "</td>
                                    <td>" . htmlspecialchars($row['date_of_birth']) . "</td>
                                    <td>" . htmlspecialchars($row['weight']) . "</td>
                                    <td>" . htmlspecialchars($row['ear_tag']) . "</td>
                                    <td>
                                      <button class='btn btn-sm btn-info' onclick='viewLivestock(\"" . htmlspecialchars($row['animal_id']) . "\")'>
                                        <i class='fa fa-eye'></i>
                                      </button>
                                    </td>
                                  </tr>";
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="livestock-content" role="tabpanel" aria-labelledby="livestock-tab">
            <div class="container-fluid">
              <div class="row mb-4">
                <div class="col-md-12">
                  <h4>Livestock List</h4>
                  <div class="card">
                    <div class="card-body">
                      <div class="mb-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLivestockModal">
                          <i class="fa fa-plus"></i> Add New Livestock
                        </button>
                      </div>
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                          <thead class="table-light">
                            <tr>
                              <th>Animal ID</th>
                              <th>Species</th>
                              <th>Breed</th>
                              <th>Gender</th>
                              <th>Date of Birth</th>
                              <th>Weight (kg)</th>
                              <th>Ear Tag</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $query = "SELECT * FROM livestock ORDER BY animal_id";
                            $result = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_array($result)) {
                              echo "<tr>
                                    <td>" . htmlspecialchars($row['animal_id']) . "</td>
                                    <td>" . htmlspecialchars($row['species']) . "</td>
                                    <td>" . htmlspecialchars($row['breed']) . "</td>
                                    <td>" . htmlspecialchars($row['gender']) . "</td>
                                    <td>" . htmlspecialchars($row['date_of_birth']) . "</td>
                                    <td>" . htmlspecialchars($row['weight']) . "</td>
                                    <td>" . htmlspecialchars($row['ear_tag']) . "</td>
                                    <td>
                                      <button class='btn btn-sm btn-info me-1' onclick='viewLivestock(\"" . htmlspecialchars($row['animal_id']) . "\")'>
                                        <i class='fa fa-eye'></i>
                                      </button>
                                      <button class='btn btn-sm btn-warning me-1' onclick='editLivestock(\"" . htmlspecialchars($row['animal_id']) . "\")'>
                                        <i class='fa fa-edit'></i>
                                      </button>
                                      <button class='btn btn-sm btn-danger' onclick='deleteLivestock(\"" . htmlspecialchars($row['animal_id']) . "\")'>
                                        <i class='fa fa-trash'></i>
                                      </button>
                                    </td>
                                  </tr>";
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="feeding-content" role="tabpanel" aria-labelledby="feeding-tab">
            <div class="container-fluid">
              <div class="row mb-4">
                <div class="col-md-12">
                  <h4>Feeding Reports</h4>
                  <div class="card">
                    <div class="card-body">
                      <div class="mb-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFeedingModal">
                          <i class="fa fa-plus"></i> Add New Feeding Report
                        </button>
                      </div>
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                          <thead class="table-light">
                            <tr>
                              <th>Report ID</th>
                              <th>Animal ID</th>
                              <th>Feeding Date</th>
                              <th>Feed Type</th>
                              <th>Quantity</th>
                              <th>Remarks</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $query = "SELECT * FROM feeding_report ORDER BY feeding_date DESC";
                            $result = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_array($result)) {
                              echo "<tr>
                                    <td>" . htmlspecialchars($row['report_id']) . "</td>
                                    <td>" . htmlspecialchars($row['animal_id']) . "</td>
                                    <td>" . htmlspecialchars($row['feeding_date']) . "</td>
                                    <td>" . htmlspecialchars($row['feed_type']) . "</td>
                                    <td>" . htmlspecialchars($row['quantity']) . "</td>
                                    <td>" . htmlspecialchars($row['remarks']) . "</td>
                                    <td>
                                      <button class='btn btn-sm btn-info me-1' onclick='viewFeeding(\"" . htmlspecialchars($row['report_id']) . "\")'>
                                        <i class='fa fa-eye'></i>
                                      </button>
                                      <button class='btn btn-sm btn-warning me-1' onclick='editFeeding(\"" . htmlspecialchars($row['report_id']) . "\")'>
                                        <i class='fa fa-edit'></i>
                                      </button>
                                      <button class='btn btn-sm btn-danger' onclick='deleteFeeding(\"" . htmlspecialchars($row['report_id']) . "\")'>
                                        <i class='fa fa-trash'></i>
                                      </button>
                                    </td>
                                  </tr>";
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="medical-content" role="tabpanel" aria-labelledby="medical-tab">
            <div class="container-fluid">
              <div class="row mb-4">
                <div class="col-md-12">
                  <h4>Medical Reports</h4>
                  <div class="card">
                    <div class="card-body">
                      <div class="mb-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMedicalModal">
                          <i class="fa fa-plus"></i> Add New Medical Report
                        </button>
                      </div>
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                          <thead class="table-light">
                            <tr>
                              <th>Record ID</th>
                              <th>Animal ID</th>
                              <th>Report Date</th>
                              <th>Diagnosis</th>
                              <th>Treatment</th>
                              <th>Medicine</th>
                              <th>Cost</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $query = "SELECT * FROM medical_report ORDER BY report_date DESC";
                            $result = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_array($result)) {
                              echo "<tr>
                                    <td>" . htmlspecialchars($row['record_id']) . "</td>
                                    <td>" . htmlspecialchars($row['animal_id']) . "</td>
                                    <td>" . htmlspecialchars($row['report_date']) . "</td>
                                    <td>" . htmlspecialchars($row['diagnosis']) . "</td>
                                    <td>" . htmlspecialchars($row['treatment']) . "</td>
                                    <td>" . htmlspecialchars($row['medicine']) . "</td>
                                    <td>" . htmlspecialchars($row['cost']) . "</td>
                                    <td>
                                      <button class='btn btn-sm btn-info me-1' onclick='viewMedical(\"" . htmlspecialchars($row['record_id']) . "\")'>
                                        <i class='fa fa-eye'></i>
                                      </button>
                                      <button class='btn btn-sm btn-warning me-1' onclick='editMedical(\"" . htmlspecialchars($row['record_id']) . "\")'>
                                        <i class='fa fa-edit'></i>
                                      </button>
                                      <button class='btn btn-sm btn-danger' onclick='deleteMedical(\"" . htmlspecialchars($row['record_id']) . "\")'>
                                        <i class='fa fa-trash'></i>
                                      </button>
                                    </td>
                                  </tr>";
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="produce-content" role="tabpanel" aria-labelledby="produce-tab">
            <div class="container-fluid">
              <div class="row mb-4">
                <div class="col-md-12">
                  <h4>Produce Reports</h4>
                  <div class="card">
                    <div class="card-body">
                      <div class="mb-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProduceModal">
                          <i class="fa fa-plus"></i> Add New Produce Report
                        </button>
                      </div>
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                          <thead class="table-light">
                            <tr>
                              <th>Report ID</th>
                              <th>Animal ID</th>
                              <th>Report Date</th>
                              <th>Produce Type</th>
                              <th>Quantity</th>
                              <th>Remarks</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $query = "SELECT * FROM produce_report ORDER BY report_date DESC";
                            $result = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_array($result)) {
                              echo "<tr>
                                    <td>" . htmlspecialchars($row['report_id']) . "</td>
                                    <td>" . htmlspecialchars($row['animal_id']) . "</td>
                                    <td>" . htmlspecialchars($row['report_date']) . "</td>
                                    <td>" . htmlspecialchars($row['produce_type']) . "</td>
                                    <td>" . htmlspecialchars($row['quantity']) . "</td>
                                    <td>" . htmlspecialchars($row['remarks']) . "</td>
                                    <td>
                                      <button class='btn btn-sm btn-info me-1' onclick='viewProduce(\"" . htmlspecialchars($row['report_id']) . "\")'>
                                        <i class='fa fa-eye'></i>
                                      </button>
                                      <button class='btn btn-sm btn-warning me-1' onclick='editProduce(\"" . htmlspecialchars($row['report_id']) . "\")'>
                                        <i class='fa fa-edit'></i>
                                      </button>
                                      <button class='btn btn-sm btn-danger' onclick='deleteProduce(\"" . htmlspecialchars($row['report_id']) . "\")'>
                                        <i class='fa fa-trash'></i>
                                      </button>
                                    </td>
                                  </tr>";
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="add-emp-content" role="tabpanel" aria-labelledby="add-emp-tab">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-8">
                  <h4>Add Employee</h4>
                  <div class="card">
                    <div class="card-body">
                      <form class="form-group" method="post" action="admin-panel1.php" id="addEmpForm">
                        <div class="row mb-3">
                          <div class="col-md-4">
                            <label class="form-label">Employee Name:</label>
                          </div>
                          <div class="col-md-8">
                            <input type="text" class="form-control" name="emp" onkeydown="return alphaOnly(event);"
                              required>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-md-4">
                            <label class="form-label">Email ID:</label>
                          </div>
                          <div class="col-md-8">
                            <input type="email" class="form-control" name="empemail" required>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-md-4">
                            <label class="form-label">Phone:</label>
                          </div>
                          <div class="col-md-8">
                            <input type="tel" class="form-control" name="phone" pattern="[0-9]{10}" required>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-md-4">
                            <label class="form-label">Password:</label>
                          </div>
                          <div class="col-md-8">
                            <input type="password" class="form-control" onkeyup='check();' name="emppassword"
                              id="emppassword" required>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-md-4">
                            <label class="form-label">Confirm Password:</label>
                          </div>
                          <div class="col-md-8" id='cpass'>
                            <input type="password" class="form-control" onkeyup='check();' name="cdpassword"
                              id="cdpassword" required>
                            <span id='message' class="form-text"></span>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-md-4">
                            <label class="form-label">Salary:</label>
                          </div>
                          <div class="col-md-8">
                            <input type="number" class="form-control" name="salary" required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <button type="submit" name="empsub" class="btn btn-primary">
                              <i class="fa fa-user-plus"></i> Add Employee
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="delete-emp-content" role="tabpanel" aria-labelledby="delete-emp-tab">
            <h4>Delete Employee</h4>
            <div class="container">
              <div class="row">
                <div class="col-md-8">
                  <div class="card">
                    <div class="card-body">
                      <form method="POST" action="admin-panel1.php" id="deleteEmpForm"
                        onsubmit="return confirmDelete()">
                        <div class="form-group mb-3">
                          <label for="empemail" class="form-label">Select Employee to Delete:</label>
                          <select class="form-select" name="empemail" id="empemail" required>
                            <option value="">-- Select Employee --</option>
                            <?php
                            $con = mysqli_connect("localhost", "root", "", "fms");
                            $query = "SELECT email, username FROM emptb ORDER BY username";
                            $result = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_array($result)) {
                              echo "<option value='" . htmlspecialchars($row['email']) . "'>" .
                                htmlspecialchars($row['username']) . " (" . htmlspecialchars($row['email']) . ")</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <button type="submit" name="empsub1" class="btn btn-danger">
                            <i class="fa fa-trash"></i> Delete Employee
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>

                  <!-- Employee List Table -->
                  <div class="card mt-4">
                    <div class="card-header">
                      <h5 class="mb-0">Current Employees</h5>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th>Employee Name</th>
                              <th>Email</th>
                              <th>Phone</th>
                              <th>Salary</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $query = "SELECT username, email, phone, salary FROM emptb ORDER BY username";
                            $result = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_array($result)) {
                              echo "<tr>
                                    <td>" . htmlspecialchars($row['username']) . "</td>
                                    <td>" . htmlspecialchars($row['email']) . "</td>
                                    <td>" . htmlspecialchars($row['phone']) . "</td>
                                    <td>" . htmlspecialchars($row['salary']) . "</td>
                                  </tr>";
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="queries-content" role="tabpanel" aria-labelledby="queries-tab">
            <div class="container-fluid">
              <div class="row mb-4">
                <div class="col-md-12">
                  <h4>System Queries</h4>
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6 mb-4">
                          <div class="card">
                            <div class="card-header">
                              <h5 class="mb-0">Employee Statistics</h5>
                            </div>
                            <div class="card-body">
                              <?php
                              $query = "SELECT 
                                COUNT(*) as total_employees,
                                AVG(salary) as avg_salary,
                                MAX(salary) as max_salary,
                                MIN(salary) as min_salary
                                FROM emptb";
                              $result = mysqli_query($con, $query);
                              $row = mysqli_fetch_array($result);
                              ?>
                              <ul class="list-group">
                                <li class="list-group-item">Total Employees: <?php echo $row['total_employees']; ?></li>
                                <li class="list-group-item">Average Salary:
                                  $<?php echo number_format($row['avg_salary'], 2); ?></li>
                                <li class="list-group-item">Highest Salary:
                                  $<?php echo number_format($row['max_salary'], 2); ?></li>
                                <li class="list-group-item">Lowest Salary:
                                  $<?php echo number_format($row['min_salary'], 2); ?></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6 mb-4">
                          <div class="card">
                            <div class="card-header">
                              <h5 class="mb-0">Livestock Statistics</h5>
                            </div>
                            <div class="card-body">
                              <?php
                              $query = "SELECT 
                                COUNT(*) as total_livestock,
                                COUNT(DISTINCT species) as species_count,
                                AVG(weight) as avg_weight
                                FROM livestock";
                              $result = mysqli_query($con, $query);
                              $row = mysqli_fetch_array($result);
                              ?>
                              <ul class="list-group">
                                <li class="list-group-item">Total Livestock: <?php echo $row['total_livestock']; ?></li>
                                <li class="list-group-item">Different Species: <?php echo $row['species_count']; ?></li>
                                <li class="list-group-item">Average Weight:
                                  <?php echo number_format($row['avg_weight'], 2); ?> kg
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="card">
                            <div class="card-header">
                              <h5 class="mb-0">Recent Reports Summary</h5>
                            </div>
                            <div class="card-body">
                              <div class="table-responsive">
                                <table class="table table-hover">
                                  <thead class="table-light">
                                    <tr>
                                      <th>Report Type</th>
                                      <th>Total Reports</th>
                                      <th>Latest Report</th>
                                      <th>Average Cost</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    // Feeding Reports
                                    $query = "SELECT 
                                      COUNT(*) as count,
                                      MAX(feeding_date) as latest_date,
                                      AVG(quantity) as avg_quantity
                                      FROM feeding_report";
                                    $result = mysqli_query($con, $query);
                                    $row = mysqli_fetch_array($result);
                                    echo "<tr>
                                          <td>Feeding Reports</td>
                                          <td>" . $row['count'] . "</td>
                                          <td>" . $row['latest_date'] . "</td>
                                          <td>" . number_format($row['avg_quantity'], 2) . " kg</td>
                                        </tr>";

                                    // Medical Reports
                                    $query = "SELECT 
                                      COUNT(*) as count,
                                      MAX(report_date) as latest_date,
                                      AVG(cost) as avg_cost
                                      FROM medical_report";
                                    $result = mysqli_query($con, $query);
                                    $row = mysqli_fetch_array($result);
                                    echo "<tr>
                                          <td>Medical Reports</td>
                                          <td>" . $row['count'] . "</td>
                                          <td>" . $row['latest_date'] . "</td>
                                          <td>$" . number_format($row['avg_cost'], 2) . "</td>
                                        </tr>";

                                    // Produce Reports
                                    $query = "SELECT 
                                      COUNT(*) as count,
                                      MAX(report_date) as latest_date,
                                      AVG(quantity) as avg_quantity
                                      FROM produce_report";
                                    $result = mysqli_query($con, $query);
                                    $row = mysqli_fetch_array($result);
                                    echo "<tr>
                                          <td>Produce Reports</td>
                                          <td>" . $row['count'] . "</td>
                                          <td>" . $row['latest_date'] . "</td>
                                          <td>" . number_format($row['avg_quantity'], 2) . " units</td>
                                        </tr>";
                                    ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Add this new tab content section before the closing div of tab-content -->
          <div class="tab-pane fade" id="reports-content" role="tabpanel" aria-labelledby="reports-tab">
            <div class="container-fluid p-0">
              <h4 class="mb-4">Generate Reports</h4>
              <?php include 'admin/reports_section.php'; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"></script>

  <script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function () {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });

      // Add fade-in animation to tab content
      document.querySelectorAll('.tab-pane').forEach(function (tab) {
        tab.classList.add('fade-in');
      });

      // Handle sidebar collapse on mobile
      const sidebarToggle = document.querySelector('.navbar-toggler');
      const sidebar = document.querySelector('.list-group');

      if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function () {
          sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function (event) {
          if (window.innerWidth < 992 &&
            !sidebar.contains(event.target) &&
            !sidebarToggle.contains(event.target)) {
            sidebar.classList.remove('show');
          }
        });
      }
    });

    function activateTab(tabId) {
      // Get the corresponding sidebar tab ID
      const sidebarTabId = tabId.replace('-content', '-tab');

      // Activate the sidebar tab
      const sidebarTab = document.querySelector(`#${sidebarTabId}`);
      if (sidebarTab) {
        const sidebarTabInstance = new bootstrap.Tab(sidebarTab);
        sidebarTabInstance.show();
      }

      // Activate the content tab
      const contentTab = document.querySelector(targetId);
      if (contentTab) {
        const contentTabInstance = new bootstrap.Tab(contentTab);
        contentTabInstance.show();
      }
    }

    document.addEventListener('DOMContentLoaded', function () {
      // Make entire panel clickable
      const panels = document.querySelectorAll('.panel');
      panels.forEach(panel => {
        panel.addEventListener('click', function (e) {
          // Find the link within this panel
          const link = this.querySelector('.dashboard-link');
          if (link) {
            const tabId = link.getAttribute('onclick').match(/'([^']+)'/)[1];
            activateTab(tabId);
          }
        });
      });
    });

    function confirmDelete() {
      const select = document.getElementById('empemail');
      const selectedOption = select.options[select.selectedIndex];
      if (!selectedOption.value) {
        alert('Please select an employee to delete');
        return false;
      }
      return confirm('Are you sure you want to delete employee: ' + selectedOption.text + '?');
    }

    // Add these functions to your existing JavaScript
    function viewEmployee(email) {
      // Implement view employee details
      alert('View employee: ' + email);
    }

    function viewLivestock(animalId) {
      // Implement view livestock details
      alert('View livestock: ' + animalId);
    }

    function editLivestock(animalId) {
      // Implement edit livestock
      alert('Edit livestock: ' + animalId);
    }

    function deleteLivestock(animalId) {
      if (confirm('Are you sure you want to delete this livestock record? This will also delete all associated reports.')) {
        const formData = new FormData();
        formData.append('animal_id', animalId);

        fetch('delete_livestock.php', {
          method: 'POST',
          body: formData
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Livestock deleted successfully!');
              location.reload();
            } else {
              alert('Error: ' + data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the livestock record.');
          });
      }
    }

    function viewFeeding(reportId) {
      // Implement view feeding report
      alert('View feeding report: ' + reportId);
    }

    function editFeeding(reportId) {
      // Fetch the feeding report data
      fetch('get_feeding.php?report_id=' + reportId)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Populate the edit form with the feeding report data
            document.getElementById('edit_report_id').value = data.feeding.report_id;
            document.getElementById('edit_animal_id').value = data.feeding.animal_id;
            document.getElementById('edit_feeding_date').value = data.feeding.feeding_date;
            document.getElementById('edit_feed_type').value = data.feeding.feed_type;
            document.getElementById('edit_quantity').value = data.feeding.quantity;
            document.getElementById('edit_remarks').value = data.feeding.remarks;

            // Show the edit modal
            const editModal = new bootstrap.Modal(document.getElementById('editFeedingModal'));
            editModal.show();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while fetching the feeding report.');
        });
    }

    function deleteFeeding(reportId) {
      if (confirm('Are you sure you want to delete this feeding report?')) {
        const formData = new FormData();
        formData.append('report_id', reportId);

        fetch('delete_feeding.php', {
          method: 'POST',
          body: formData
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Feeding report deleted successfully!');
              location.reload();
            } else {
              alert('Error: ' + data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the feeding report.');
          });
      }
    }

    function viewMedical(recordId) {
      // Fetch the medical report data
      fetch('get_medical.php?record_id=' + recordId)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Populate the edit form with the medical report data
            document.getElementById('edit_record_id').value = data.medical.record_id;
            document.getElementById('edit_medical_animal_id').value = data.medical.animal_id;
            document.getElementById('edit_report_date').value = data.medical.report_date;
            document.getElementById('edit_diagnosis').value = data.medical.diagnosis;
            document.getElementById('edit_treatment').value = data.medical.treatment;
            document.getElementById('edit_medicine').value = data.medical.medicine;
            document.getElementById('edit_cost').value = data.medical.cost;

            // Show the edit modal
            const editModal = new bootstrap.Modal(document.getElementById('editMedicalModal'));
            editModal.show();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while fetching the medical report.');
        });
    }

    function editMedical(recordId) {
      // Fetch the medical report data
      fetch('get_medical.php?record_id=' + recordId)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Populate the edit form with the medical report data
            document.getElementById('edit_record_id').value = data.medical.record_id;
            document.getElementById('edit_medical_animal_id').value = data.medical.animal_id;
            document.getElementById('edit_report_date').value = data.medical.report_date;
            document.getElementById('edit_diagnosis').value = data.medical.diagnosis;
            document.getElementById('edit_treatment').value = data.medical.treatment;
            document.getElementById('edit_medicine').value = data.medical.medicine;
            document.getElementById('edit_cost').value = data.medical.cost;

            // Show the edit modal
            const editModal = new bootstrap.Modal(document.getElementById('editMedicalModal'));
            editModal.show();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while fetching the medical report.');
        });
    }

    function deleteMedical(recordId) {
      if (confirm('Are you sure you want to delete this medical report?')) {
        const formData = new FormData();
        formData.append('record_id', recordId);

        fetch('delete_medical.php', {
          method: 'POST',
          body: formData
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Medical report deleted successfully!');
              location.reload();
            } else {
              alert('Error: ' + data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the medical report.');
          });
      }
    }

    function viewProduce(reportId) {
      // Fetch the produce report data
      fetch('get_produce.php?report_id=' + reportId)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Populate the edit form with the produce report data
            document.getElementById('edit_produce_report_id').value = data.produce.report_id;
            document.getElementById('edit_produce_animal_id').value = data.produce.animal_id;
            document.getElementById('edit_produce_date').value = data.produce.report_date;
            document.getElementById('edit_produce_type').value = data.produce.produce_type;
            document.getElementById('edit_produce_quantity').value = data.produce.quantity;
            document.getElementById('edit_produce_remarks').value = data.produce.remarks;

            // Show the edit modal
            const editModal = new bootstrap.Modal(document.getElementById('editProduceModal'));
            editModal.show();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while fetching the produce report.');
        });
    }

    function editProduce(reportId) {
      // Fetch the produce report data
      fetch('get_produce.php?report_id=' + reportId)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Populate the edit form with the produce report data
            document.getElementById('edit_produce_report_id').value = data.produce.report_id;
            document.getElementById('edit_produce_animal_id').value = data.produce.animal_id;
            document.getElementById('edit_produce_date').value = data.produce.report_date;
            document.getElementById('edit_produce_type').value = data.produce.produce_type;
            document.getElementById('edit_produce_quantity').value = data.produce.quantity;
            document.getElementById('edit_produce_remarks').value = data.produce.remarks;

            // Show the edit modal
            const editModal = new bootstrap.Modal(document.getElementById('editProduceModal'));
            editModal.show();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while fetching the produce report.');
        });
    }

    function deleteProduce(reportId) {
      if (confirm('Are you sure you want to delete this produce report?')) {
        const formData = new FormData();
        formData.append('report_id', reportId);

        fetch('delete_produce.php', {
          method: 'POST',
          body: formData
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Produce report deleted successfully!');
              location.reload();
            } else {
              alert('Error: ' + data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the produce report.');
          });
      }
    }
  </script>

  <!-- Add Livestock Modal -->
  <div class="modal fade" id="addLivestockModal" tabindex="-1" aria-labelledby="addLivestockModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addLivestockModalLabel">Add New Livestock</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addLivestockForm" method="post" action="add_livestock.php">
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Animal ID</label>
                <input type="text" class="form-control" name="animal_id" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Species</label>
                <select class="form-select" name="species" required>
                  <option value="">Select Species</option>
                  <option value="Cow">Cow</option>
                  <option value="Goat">Goat</option>
                  <option value="Sheep">Sheep</option>
                  <option value="Pig">Pig</option>
                  <option value="Chicken">Chicken</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Breed</label>
                <input type="text" class="form-control" name="breed" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Gender</label>
                <select class="form-select" name="gender" required>
                  <option value="">Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" name="date_of_birth" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Weight (kg)</label>
                <input type="number" step="0.01" class="form-control" name="weight" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Ear Tag</label>
                <input type="text" class="form-control" name="ear_tag" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Add Livestock</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Medical Report Modal -->
  <div class="modal fade" id="addMedicalModal" tabindex="-1" aria-labelledby="addMedicalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addMedicalModalLabel">Add New Medical Report</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addMedicalForm" method="post" action="add_medical.php">
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Animal ID</label>
                <select class="form-select" name="animal_id" required>
                  <option value="">Select Animal</option>
                  <?php
                  $query = "SELECT animal_id FROM livestock ORDER BY animal_id";
                  $result = mysqli_query($con, $query);
                  while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='" . htmlspecialchars($row['animal_id']) . "'>" .
                      htmlspecialchars($row['animal_id']) . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Report Date</label>
                <input type="date" class="form-control" name="report_date" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label class="form-label">Diagnosis</label>
                <textarea class="form-control" name="diagnosis" rows="3" required></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label class="form-label">Treatment</label>
                <textarea class="form-control" name="treatment" rows="3" required></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Medicine</label>
                <input type="text" class="form-control" name="medicine" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Cost</label>
                <input type="number" step="0.01" class="form-control" name="cost" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Add Medical Report</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Produce Report Modal -->
  <div class="modal fade" id="addProduceModal" tabindex="-1" aria-labelledby="addProduceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProduceModalLabel">Add New Produce Report</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addProduceForm" method="post" action="add_produce.php">
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Animal ID</label>
                <select class="form-select" name="animal_id" required>
                  <option value="">Select Animal</option>
                  <?php
                  $query = "SELECT animal_id FROM livestock ORDER BY animal_id";
                  $result = mysqli_query($con, $query);
                  while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='" . htmlspecialchars($row['animal_id']) . "'>" .
                      htmlspecialchars($row['animal_id']) . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Report Date</label>
                <input type="date" class="form-control" name="report_date" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Produce Type</label>
                <select class="form-select" name="produce_type" required>
                  <option value="">Select Produce Type</option>
                  <option value="Milk">Milk</option>
                  <option value="Eggs">Eggs</option>
                  <option value="Wool">Wool</option>
                  <option value="Meat">Meat</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Quantity</label>
                <input type="number" step="0.01" class="form-control" name="quantity" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label class="form-label">Remarks</label>
                <textarea class="form-control" name="remarks" rows="3"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Add Produce Report</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Feeding Report Modal -->
  <div class="modal fade" id="addFeedingModal" tabindex="-1" aria-labelledby="addFeedingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addFeedingModalLabel">Add New Feeding Report</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addFeedingForm" method="post" action="add_feeding.php">
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Animal ID</label>
                <select class="form-select" name="animal_id" required>
                  <option value="">Select Animal</option>
                  <?php
                  $query = "SELECT animal_id FROM livestock ORDER BY animal_id";
                  $result = mysqli_query($con, $query);
                  while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='" . htmlspecialchars($row['animal_id']) . "'>" .
                      htmlspecialchars($row['animal_id']) . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Feeding Date</label>
                <input type="date" class="form-control" name="feeding_date" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Feed Type</label>
                <select class="form-select" name="feed_type" required>
                  <option value="">Select Feed Type</option>
                  <option value="Hay">Hay</option>
                  <option value="Grain">Grain</option>
                  <option value="Silage">Silage</option>
                  <option value="Concentrate">Concentrate</option>
                  <option value="Mixed Feed">Mixed Feed</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Quantity (kg)</label>
                <input type="number" step="0.01" class="form-control" name="quantity" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label class="form-label">Remarks</label>
                <textarea class="form-control" name="remarks" rows="3"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Add Feeding Report</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Edit Feeding Report Modal -->
  <div class="modal fade" id="editFeedingModal" tabindex="-1" aria-labelledby="editFeedingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editFeedingModalLabel">Edit Feeding Report</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editFeedingForm" method="post" action="edit_feeding.php">
            <input type="hidden" name="report_id" id="edit_report_id">
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Animal ID</label>
                <select class="form-select" name="animal_id" id="edit_animal_id" required>
                  <option value="">Select Animal</option>
                  <?php
                  $query = "SELECT animal_id FROM livestock ORDER BY animal_id";
                  $result = mysqli_query($con, $query);
                  while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='" . htmlspecialchars($row['animal_id']) . "'>" .
                      htmlspecialchars($row['animal_id']) . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Feeding Date</label>
                <input type="date" class="form-control" name="feeding_date" id="edit_feeding_date" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Feed Type</label>
                <select class="form-select" name="feed_type" id="edit_feed_type" required>
                  <option value="">Select Feed Type</option>
                  <option value="Hay">Hay</option>
                  <option value="Grain">Grain</option>
                  <option value="Silage">Silage</option>
                  <option value="Concentrate">Concentrate</option>
                  <option value="Mixed Feed">Mixed Feed</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Quantity (kg)</label>
                <input type="number" step="0.01" class="form-control" name="quantity" id="edit_quantity" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label class="form-label">Remarks</label>
                <textarea class="form-control" name="remarks" id="edit_remarks" rows="3"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update Feeding Report</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Edit Medical Report Modal -->
  <div class="modal fade" id="editMedicalModal" tabindex="-1" aria-labelledby="editMedicalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editMedicalModalLabel">Edit Medical Report</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editMedicalForm" method="post" action="edit_medical.php">
            <input type="hidden" name="record_id" id="edit_record_id">
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Animal ID</label>
                <select class="form-select" name="animal_id" id="edit_medical_animal_id" required>
                  <option value="">Select Animal</option>
                  <?php
                  $query = "SELECT animal_id FROM livestock ORDER BY animal_id";
                  $result = mysqli_query($con, $query);
                  while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='" . htmlspecialchars($row['animal_id']) . "'>" .
                      htmlspecialchars($row['animal_id']) . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Report Date</label>
                <input type="date" class="form-control" name="report_date" id="edit_report_date" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label class="form-label">Diagnosis</label>
                <textarea class="form-control" name="diagnosis" id="edit_diagnosis" rows="3" required></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label class="form-label">Treatment</label>
                <textarea class="form-control" name="treatment" id="edit_treatment" rows="3" required></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Medicine</label>
                <input type="text" class="form-control" name="medicine" id="edit_medicine" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Cost</label>
                <input type="number" step="0.01" class="form-control" name="cost" id="edit_cost" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update Medical Report</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Edit Produce Report Modal -->
  <div class="modal fade" id="editProduceModal" tabindex="-1" aria-labelledby="editProduceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProduceModalLabel">Edit Produce Report</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editProduceForm" method="post" action="edit_produce.php">
            <input type="hidden" name="report_id" id="edit_produce_report_id">
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Animal ID</label>
                <select class="form-select" name="animal_id" id="edit_produce_animal_id" required>
                  <option value="">Select Animal</option>
                  <?php
                  $query = "SELECT animal_id FROM livestock ORDER BY animal_id";
                  $result = mysqli_query($con, $query);
                  while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='" . htmlspecialchars($row['animal_id']) . "'>" .
                      htmlspecialchars($row['animal_id']) . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Report Date</label>
                <input type="date" class="form-control" name="report_date" id="edit_produce_date" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Produce Type</label>
                <select class="form-select" name="produce_type" id="edit_produce_type" required>
                  <option value="">Select Produce Type</option>
                  <option value="Milk">Milk</option>
                  <option value="Eggs">Eggs</option>
                  <option value="Wool">Wool</option>
                  <option value="Meat">Meat</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Quantity</label>
                <input type="number" step="0.01" class="form-control" name="quantity" id="edit_produce_quantity"
                  required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label class="form-label">Remarks</label>
                <textarea class="form-control" name="remarks" id="edit_produce_remarks" rows="3"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update Produce Report</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Edit Employee Modal -->
  <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editEmployeeForm" method="post" action="edit_employee.php">
            <input type="hidden" name="email" id="edit_email">
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Employee Name</label>
                <input type="text" class="form-control" name="username" id="edit_username" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email ID</label>
                <input type="email" class="form-control" id="edit_email_display" disabled>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="tel" class="form-control" name="phone" id="edit_phone" pattern="[0-9]{10}" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Salary</label>
                <input type="number" class="form-control" name="salary" id="edit_salary" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">New Password (leave blank to keep current)</label>
                <input type="password" class="form-control" name="password" id="edit_password">
              </div>
              <div class="col-md-6">
                <label class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" name="confirm_password" id="edit_confirm_password">
                <span id="edit_password_message" class="form-text"></span>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update Employee</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Add this before the closing body tag -->
  <script>
    // ... existing JavaScript ...

    // Form submission handlers
    document.getElementById('addLivestockForm').addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch('add_livestock.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Livestock added successfully!');
            location.reload();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while adding livestock.');
        });
    });

    document.getElementById('addMedicalForm').addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch('add_medical.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Medical report added successfully!');
            location.reload();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while adding medical report.');
        });
    });

    document.getElementById('addProduceForm').addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch('add_produce.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Produce report added successfully!');
            location.reload();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while adding produce report.');
        });
    });

    document.getElementById('addFeedingForm').addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch('add_feeding.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Feeding report added successfully!');
            location.reload();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while adding feeding report.');
        });
    });

    // Initialize all modals
    document.addEventListener('DOMContentLoaded', function () {
      const modals = ['addLivestockModal', 'addMedicalModal', 'addProduceModal', 'addFeedingModal'];
      modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
          new bootstrap.Modal(modal);
        }
      });
    });

    // Add event listener for edit feeding form submission
    document.getElementById('editFeedingForm').addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch('edit_feeding.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Feeding report updated successfully!');
            location.reload();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while updating the feeding report.');
        });
    });

    // Add event listener for edit medical form submission
    document.getElementById('editMedicalForm').addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch('edit_medical.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Medical report updated successfully!');
            location.reload();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while updating the medical report.');
        });
    });

    // Add event listener for edit produce form submission
    document.getElementById('editProduceForm').addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch('edit_produce.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Produce report updated successfully!');
            location.reload();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while updating the produce report.');
        });
    });

    function editEmployee(email) {
      // Fetch the employee data
      fetch('get_employee.php?email=' + encodeURIComponent(email))
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Populate the edit form with the employee data
            document.getElementById('edit_email').value = data.employee.email;
            document.getElementById('edit_email_display').value = data.employee.email;
            document.getElementById('edit_username').value = data.employee.username;
            document.getElementById('edit_phone').value = data.employee.phone;
            document.getElementById('edit_salary').value = data.employee.salary;

            // Clear password fields
            document.getElementById('edit_password').value = '';
            document.getElementById('edit_confirm_password').value = '';
            document.getElementById('edit_password_message').textContent = '';

            // Show the edit modal
            const editModal = new bootstrap.Modal(document.getElementById('editEmployeeModal'));
            editModal.show();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while fetching the employee data.');
        });
    }

    // Add password validation for edit form
    document.getElementById('edit_confirm_password').addEventListener('keyup', function () {
      const password = document.getElementById('edit_password').value;
      const confirmPassword = this.value;
      const message = document.getElementById('edit_password_message');

      if (password === '' && confirmPassword === '') {
        message.textContent = '';
        message.style.color = '';
      } else if (password === confirmPassword) {
        message.textContent = 'Passwords match';
        message.style.color = 'green';
      } else {
        message.textContent = 'Passwords do not match';
        message.style.color = 'red';
      }
    });

    // Add event listener for edit employee form submission
    document.getElementById('editEmployeeForm').addEventListener('submit', function (e) {
      e.preventDefault();

      const password = document.getElementById('edit_password').value;
      const confirmPassword = document.getElementById('edit_confirm_password').value;

      if (password !== '' && password !== confirmPassword) {
        alert('Passwords do not match!');
        return;
      }

      const formData = new FormData(this);

      fetch('edit_employee.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Employee updated successfully!');
            location.reload();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while updating the employee.');
        });
    });

    // Update the employee list table to include edit button
    document.addEventListener('DOMContentLoaded', function () {
      const employeeTable = document.querySelector('#emp-content table tbody');
      if (employeeTable) {
        const rows = employeeTable.getElementsByTagName('tr');
        for (let row of rows) {
          const cells = row.getElementsByTagName('td');
          if (cells.length >= 5) {
            const email = cells[1].textContent;
            const actionsCell = cells[4];
            actionsCell.innerHTML = `
              <button class='btn btn-sm btn-info me-1' onclick='viewEmployee("${email}")'>
                <i class='fa fa-eye'></i>
              </button>
              <button class='btn btn-sm btn-warning me-1' onclick='editEmployee("${email}")'>
                <i class='fa fa-edit'></i>
              </button>
            `;
          }
        }
      }
    });
  </script>
</body>

</html>