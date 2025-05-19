<?php
// Start output buffering at the very beginning
ob_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors to browser
ini_set('log_errors', 1); // Log errors instead

// Try to set up logging to both custom log and PHP error log
$logDir = __DIR__ . '/../logs';
$customLogFile = $logDir . '/error.log';
$phpLogFile = ini_get('error_log') ?: 'C:/xampp/php/logs/php_error.log';

// Function to ensure logs directory exists and is writable
function ensureLogDirectory($dir)
{
    if (!file_exists($dir)) {
        if (!@mkdir($dir, 0755, true)) {
            error_log("Failed to create logs directory: $dir");
            return false;
        }
    }
    if (!is_writable($dir)) {
        error_log("Logs directory is not writable: $dir");
        return false;
    }
    return true;
}

// Function to log errors with more context
function logError($message, $context = array())
{
    global $logDir, $customLogFile, $phpLogFile;

    // Ensure logs directory exists
    if (!ensureLogDirectory($logDir)) {
        // If we can't create/write to custom log, just use PHP's error log
        error_log($message . (!empty($context) ? ' Context: ' . json_encode($context) : ''));
        return;
    }

    $timestamp = date('Y-m-d H:i:s');
    $contextStr = !empty($context) ? ' Context: ' . json_encode($context) : '';
    $logMessage = "[$timestamp] $message$contextStr\n";

    // Try to write to custom log file
    if (@file_put_contents($customLogFile, $logMessage, FILE_APPEND) === false) {
        error_log("Failed to write to custom log file: $customLogFile");
        error_log($message . $contextStr);
    }

    // Also log to PHP error log
    error_log($message . $contextStr);
}

// Function to send JSON response and exit
function sendJsonResponse($data)
{
    // Clear any previous output
    while (ob_get_level()) {
        ob_end_clean();
    }

    // Ensure we're sending JSON
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Function to handle errors and send JSON response
function handleError($message, $context = array())
{
    logError($message, $context);
    sendJsonResponse([
        'success' => false,
        'message' => $message
    ]);
}

try {
    // Log the start of the request
    logError("=== Starting report generation request ===", [
        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
        'REQUEST_URI' => $_SERVER['REQUEST_URI'],
        'POST_DATA' => $_POST,
        'GET_DATA' => $_GET
    ]);

    // Get the request data from either POST or GET
    $requestData = $_POST;
    if (empty($requestData)) {
        $requestData = $_GET;
        logError("No POST data found, using GET data", ['GET_DATA' => $_GET]);
    }

    // Validate the request data
    if (empty($requestData)) {
        handleError('No request data found in POST or GET');
    }

    if (!isset($requestData['action'])) {
        handleError('No action specified in the request data');
    }

    if (!in_array($requestData['action'], ['weekly', 'monthly'])) {
        handleError('Invalid action specified. Must be either "weekly" or "monthly".');
    }

    // Check required files
    $requiredFiles = [
        '../includes/db_connection.php',
        '../mail_functions.php'
    ];

    foreach ($requiredFiles as $file) {
        $fullPath = realpath($file);
        if (!file_exists($fullPath)) {
            throw new Exception("Required file not found: $file (Full path: $fullPath)");
        }
        logError("Including required file", ['file' => $file, 'full_path' => $fullPath]);
        require_once $file;
    }

    // Test database connection
    try {
        $con = getConnection();
        if (!$con) {
            throw new Exception("Database connection failed: " . mysqli_connect_error());
        }
        logError("Database connection successful", [
            'server_info' => mysqli_get_server_info($con),
            'host_info' => mysqli_get_host_info($con)
        ]);
    } catch (Exception $e) {
        logError("Database connection test failed", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        throw $e;
    }

    // Handle the report generation request
    $response = array('success' => false, 'message' => '');

    try {
        $action = $requestData['action'];
        logError("Processing report generation request", ['action' => $action]);

        switch ($action) {
            case 'weekly':
                $reportData = generateWeeklyReport();
                if (empty($reportData)) {
                    handleError("Generated report data is empty");
                }
                $result = sendReportNotification('Weekly', $reportData);
                if ($result['success']) {
                    sendJsonResponse($result);
                } else {
                    handleError($result['message']);
                }
                break;

            case 'monthly':
                $reportData = generateMonthlyReport();
                if (empty($reportData)) {
                    handleError("Generated report data is empty");
                }
                $result = sendReportNotification('Monthly', $reportData);
                if ($result['success']) {
                    sendJsonResponse($result);
                } else {
                    handleError($result['message']);
                }
                break;
        }
    } catch (Exception $e) {
        handleError("Error generating report: " . $e->getMessage(), [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }

} catch (Exception $e) {
    handleError("Fatal error in generate_reports.php: " . $e->getMessage(), [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}

// Function to generate weekly report
function generateWeeklyReport()
{
    try {
        logError("Starting weekly report generation");

        $con = getConnection();
        if (!$con) {
            throw new Exception("Database connection failed: " . mysqli_connect_error());
        }

        $reportData = array();
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime('-7 days'));
        logError("Generating weekly report from $startDate to $endDate");

        // Get feeding reports data
        $feedingQuery = "SELECT COUNT(*) as total_feeding, SUM(quantity) as total_feed_quantity 
                        FROM feeding_report 
                        WHERE feeding_date BETWEEN ? AND ?";
        $stmt = $con->prepare($feedingQuery);
        if (!$stmt) {
            throw new Exception("Failed to prepare feeding query: " . $con->error);
        }

        $stmt->bind_param("ss", $startDate, $endDate);
        if (!$stmt->execute()) {
            throw new Exception("Failed to execute feeding query: " . $stmt->error);
        }

        $feedingResult = $stmt->get_result()->fetch_assoc();
        logError("Feeding report results: " . print_r($feedingResult, true));

        // Get medical reports data
        $medicalQuery = "SELECT COUNT(*) as total_medical, SUM(cost) as total_medical_cost 
                        FROM medical_report 
                        WHERE report_date BETWEEN ? AND ?";
        $stmt = $con->prepare($medicalQuery);
        if (!$stmt) {
            throw new Exception("Failed to prepare medical query: " . $con->error);
        }

        $stmt->bind_param("ss", $startDate, $endDate);
        if (!$stmt->execute()) {
            throw new Exception("Failed to execute medical query: " . $stmt->error);
        }

        $medicalResult = $stmt->get_result()->fetch_assoc();
        logError("Medical report results: " . print_r($medicalResult, true));

        // Get produce reports data
        $produceQuery = "SELECT COUNT(*) as total_produce, SUM(quantity) as total_produce_quantity 
                        FROM produce_report 
                        WHERE report_date BETWEEN ? AND ?";
        $stmt = $con->prepare($produceQuery);
        if (!$stmt) {
            throw new Exception("Failed to prepare produce query: " . $con->error);
        }

        $stmt->bind_param("ss", $startDate, $endDate);
        if (!$stmt->execute()) {
            throw new Exception("Failed to execute produce query: " . $stmt->error);
        }

        $produceResult = $stmt->get_result()->fetch_assoc();
        logError("Produce report results: " . print_r($produceResult, true));

        // Compile report data
        $reportData = array(
            'report_period' => "Weekly Report ({$startDate} to {$endDate})",
            'total_feeding_reports' => $feedingResult['total_feeding'] ?? 0,
            'total_feed_quantity' => number_format($feedingResult['total_feed_quantity'] ?? 0, 2) . ' kg',
            'total_medical_reports' => $medicalResult['total_medical'] ?? 0,
            'total_medical_cost' => number_format($medicalResult['total_medical_cost'] ?? 0, 2),
            'total_produce_reports' => $produceResult['total_produce'] ?? 0,
            'total_produce_quantity' => number_format($produceResult['total_produce_quantity'] ?? 0, 2) . ' units'
        );

        logError("Compiled weekly report data: " . print_r($reportData, true));
        return $reportData;

    } catch (Exception $e) {
        logError("Error in generateWeeklyReport: " . $e->getMessage());
        throw $e;
    }
}

// Function to generate monthly report
function generateMonthlyReport()
{
    try {
        logError("Starting monthly report generation");

        $con = getConnection();
        if (!$con) {
            throw new Exception("Database connection failed: " . mysqli_connect_error());
        }

        $reportData = array();
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime('-30 days'));
        logError("Generating monthly report from $startDate to $endDate");

        // Get feeding reports data
        $feedingQuery = "SELECT COUNT(*) as total_feeding, 
                               SUM(quantity) as total_feed_quantity,
                               COUNT(DISTINCT animal_id) as animals_fed
                        FROM feeding_report 
                        WHERE feeding_date BETWEEN ? AND ?";
        $stmt = $con->prepare($feedingQuery);
        if (!$stmt) {
            throw new Exception("Failed to prepare feeding query: " . $con->error);
        }

        $stmt->bind_param("ss", $startDate, $endDate);
        if (!$stmt->execute()) {
            throw new Exception("Failed to execute feeding query: " . $stmt->error);
        }

        $feedingResult = $stmt->get_result()->fetch_assoc();
        logError("Feeding report results: " . print_r($feedingResult, true));

        // Get medical reports data
        $medicalQuery = "SELECT COUNT(*) as total_medical, 
                               SUM(cost) as total_medical_cost,
                               COUNT(DISTINCT animal_id) as animals_treated
                        FROM medical_report 
                        WHERE report_date BETWEEN ? AND ?";
        $stmt = $con->prepare($medicalQuery);
        if (!$stmt) {
            throw new Exception("Failed to prepare medical query: " . $con->error);
        }

        $stmt->bind_param("ss", $startDate, $endDate);
        if (!$stmt->execute()) {
            throw new Exception("Failed to execute medical query: " . $stmt->error);
        }

        $medicalResult = $stmt->get_result()->fetch_assoc();
        logError("Medical report results: " . print_r($medicalResult, true));

        // Get produce reports data
        $produceQuery = "SELECT COUNT(*) as total_produce, 
                               SUM(quantity) as total_produce_quantity,
                               COUNT(DISTINCT animal_id) as animals_producing
                        FROM produce_report 
                        WHERE report_date BETWEEN ? AND ?";
        $stmt = $con->prepare($produceQuery);
        if (!$stmt) {
            throw new Exception("Failed to prepare produce query: " . $con->error);
        }

        $stmt->bind_param("ss", $startDate, $endDate);
        if (!$stmt->execute()) {
            throw new Exception("Failed to execute produce query: " . $stmt->error);
        }

        $produceResult = $stmt->get_result()->fetch_assoc();
        logError("Produce report results: " . print_r($produceResult, true));

        // Get livestock statistics
        $livestockQuery = "SELECT COUNT(*) as total_livestock,
                                 COUNT(DISTINCT species) as species_count
                          FROM livestock";
        $stmt = $con->prepare($livestockQuery);
        if (!$stmt) {
            throw new Exception("Failed to prepare livestock query: " . $con->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Failed to execute livestock query: " . $stmt->error);
        }

        $livestockResult = $stmt->get_result()->fetch_assoc();
        logError("Livestock results: " . print_r($livestockResult, true));

        // Compile report data
        $reportData = array(
            'report_period' => "Monthly Report ({$startDate} to {$endDate})",
            'total_livestock' => $livestockResult['total_livestock'] ?? 0,
            'species_count' => $livestockResult['species_count'] ?? 0,
            'total_feeding_reports' => $feedingResult['total_feeding'] ?? 0,
            'total_feed_quantity' => number_format($feedingResult['total_feed_quantity'] ?? 0, 2) . ' kg',
            'animals_fed' => $feedingResult['animals_fed'] ?? 0,
            'total_medical_reports' => $medicalResult['total_medical'] ?? 0,
            'total_medical_cost' => number_format($medicalResult['total_medical_cost'] ?? 0, 2),
            'animals_treated' => $medicalResult['animals_treated'] ?? 0,
            'total_produce_reports' => $produceResult['total_produce'] ?? 0,
            'total_produce_quantity' => number_format($produceResult['total_produce_quantity'] ?? 0, 2) . ' units',
            'animals_producing' => $produceResult['animals_producing'] ?? 0
        );

        logError("Compiled monthly report data: " . print_r($reportData, true));
        return $reportData;

    } catch (Exception $e) {
        logError("Error in generateMonthlyReport: " . $e->getMessage());
        throw $e;
    }
}
?>