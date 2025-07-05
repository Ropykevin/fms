<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;
use Dompdf\Options;

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to log errors to a file (only if not already defined)
if (!function_exists('logError')) {
    function logError($message)
    {
        $logDir = __DIR__ . '/../logs';
        $logFile = $logDir . '/error.log';

        // Create logs directory if it doesn't exist
        if (!file_exists($logDir)) {
            if (!@mkdir($logDir, 0755, true)) {
                // If we can't create the directory, try to write to PHP's error log
                error_log("Failed to create logs directory: " . $logDir);
                error_log($message);
                return;
            }
        }

        // Check if directory is writable
        if (!is_writable($logDir)) {
            error_log("Logs directory is not writable: " . $logDir);
            error_log($message);
            return;
        }

        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] $message\n";

        // Try to write to the log file
        if (@file_put_contents($logFile, $logMessage, FILE_APPEND) === false) {
            error_log("Failed to write to log file: " . $logFile);
            error_log($message);
        }
    }
}

function getAdminEmail()
{
    try {
        $con = mysqli_connect("localhost", "root", "", "fms");
        if (!$con) {
            error_log("Database connection failed in getAdminEmail: " . mysqli_connect_error());
            return 'ropykevin@gmail.com';
        }

        // Get admin email from contact table where name is 'Admin'
        $query = "SELECT email FROM contact WHERE name = 'Admin' LIMIT 1";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            error_log("Admin email found: " . $row['email']);
            return $row['email'];
        }

        error_log("No admin email found in database, using fallback");
        return 'ropykevin@gmail.com';
    } catch (Exception $e) {
        error_log("Error in getAdminEmail: " . $e->getMessage());
        return 'ropykevin@gmail.com';
    }
}

function sendReportNotification($reportType, $reportData)
{
    try {
        logError("=== Starting report generation ===");
        logError("Report Type: " . $reportType);
        logError("Report Data: " . print_r($reportData, true));

        // Validate report data
        if (empty($reportData)) {
            throw new Exception("Report data is empty");
        }

        // Get admin email
        $to = getAdminEmail();
        logError("Sending report to: " . $to);

        // Create HTML content
        $html = "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>{$reportType} Report</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h1 { color: #2c3e50; text-align: center; }
                h2 { color: #34495e; margin-top: 20px; }
                .section { margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 5px; }
                .timestamp { color: #7f8c8d; font-size: 0.9em; text-align: center; }
                table { width: 100%; border-collapse: collapse; margin: 10px 0; }
                th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
                th { background-color: #f2f2f2; }
            </style>
        </head>
        <body>
            <h1>Farm Management System - {$reportData['report_period']}</h1>
            <p class='timestamp'>Generated on: " . date('Y-m-d H:i:s') . "</p>";

        // Add report sections
        if ($reportType === 'Monthly') {
            $html .= "
            <div class='section'>
                <h2>Livestock Overview</h2>
                <table>
                    <tr><th>Metric</th><th>Value</th></tr>
                    <tr><td>Total Livestock</td><td>" . (isset($reportData['total_livestock']) ? $reportData['total_livestock'] : 'N/A') . "</td></tr>
                    <tr><td>Number of Species</td><td>" . (isset($reportData['species_count']) ? $reportData['species_count'] : 'N/A') . "</td></tr>
                </table>
            </div>";
        }

        $html .= "
            <div class='section'>
                <h2>Feeding Reports</h2>
                <table>
                    <tr><th>Metric</th><th>Value</th></tr>
                    <tr><td>Total Feeding Reports</td><td>" . (isset($reportData['total_feeding_reports']) ? $reportData['total_feeding_reports'] : 'N/A') . "</td></tr>
                    <tr><td>Total Feed Quantity</td><td>" . (isset($reportData['total_feed_quantity']) ? $reportData['total_feed_quantity'] : 'N/A') . "</td></tr>";
        if ($reportType === 'Monthly') {
            $html .= "<tr><td>Animals Fed</td><td>" . (isset($reportData['animals_fed']) ? $reportData['animals_fed'] : 'N/A') . "</td></tr>";
        }
        $html .= "
                </table>
            </div>

            <div class='section'>
                <h2>Medical Reports</h2>
                <table>
                    <tr><th>Metric</th><th>Value</th></tr>
                    <tr><td>Total Medical Reports</td><td>" . (isset($reportData['total_medical_reports']) ? $reportData['total_medical_reports'] : 'N/A') . "</td></tr>
                    <tr><td>Total Medical Costs</td><td>₱" . (isset($reportData['total_medical_cost']) ? $reportData['total_medical_cost'] : 'N/A') . "</td></tr>";
        if ($reportType === 'Monthly') {
            $html .= "<tr><td>Animals Treated</td><td>" . (isset($reportData['animals_treated']) ? $reportData['animals_treated'] : 'N/A') . "</td></tr>";
        }
        $html .= "
                </table>
            </div>

            <div class='section'>
                <h2>Produce Reports</h2>
                <table>
                    <tr><th>Metric</th><th>Value</th></tr>
                    <tr><td>Total Produce Reports</td><td>" . (isset($reportData['total_produce_reports']) ? $reportData['total_produce_reports'] : 'N/A') . "</td></tr>
                    <tr><td>Total Produce Quantity</td><td>" . (isset($reportData['total_produce_quantity']) ? $reportData['total_produce_quantity'] : 'N/A') . "</td></tr>";
        if ($reportType === 'Monthly') {
            $html .= "<tr><td>Animals Producing</td><td>" . (isset($reportData['animals_producing']) ? $reportData['animals_producing'] : 'N/A') . "</td></tr>";
        }
        $html .= "
                </table>
            </div>
        </body>
        </html>";

        try {
            logError("Initializing PHPMailer...");

            // Check if PHPMailer class exists
            if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
                logError("PHPMailer class not found. Checking autoload...");
                if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
                    logError("Composer autoload file not found. Skipping email sending.");
                    return array(
                        'success' => true,
                        'message' => "Report generated successfully. Email sending skipped (autoload not found).",
                        'report_data' => $reportData
                    );
                }
                require_once __DIR__ . '/vendor/autoload.php';
                if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
                    logError("PHPMailer library not found. Skipping email sending.");
                    return array(
                        'success' => true,
                        'message' => "Report generated successfully. Email sending skipped (PHPMailer not found).",
                        'report_data' => $reportData
                    );
                }
            }

            $mail = new PHPMailer(true);
            logError("PHPMailer object created");

            // Server settings - Using Gmail SMTP
            $mail->SMTPDebug = 0; // Disable debug output to prevent hanging
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Gmail SMTP server
            $mail->Port = 587;               // Gmail SMTP port
            $mail->SMTPAuth = true;          // Enable authentication
            $mail->SMTPSecure = 'tls';       // Enable TLS encryption
            $mail->Username = 'farmmanagementsystem77@gmail.com'; // Replace with your Gmail
            $mail->Password = 'rtcc brzp qwze rlli';    // Replace with your app password

            logError("SMTP settings configured");

            // Recipients
            $mail->setFrom('farmmanagementsystem77@gmail.com', 'Farm Management System'); // Use your Gmail
            $mail->addAddress($to);
            logError("Recipients configured");

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Farm Management System - {$reportType} Report";
            $mail->Body = $html;
            $mail->AltBody = strip_tags($html);
            logError("Email content prepared");

            logError("Attempting to send email...");
            if (!$mail->send()) {
                logError("Email sending failed: " . $mail->ErrorInfo);
                return array(
                    'success' => true,
                    'message' => "Report generated successfully. Email sending failed: " . $mail->ErrorInfo,
                    'report_data' => $reportData
                );
            }
            logError("Email sent successfully");

            return array(
                'success' => true,
                'message' => "Report has been sent successfully to {$to}",
                'report_data' => $reportData
            );
        } catch (Exception $e) {
            logError("Email sending failed: " . $e->getMessage());
            logError("Stack trace: " . $e->getTraceAsString());
            return array(
                'success' => true,
                'message' => "Report generated successfully. Email sending failed: " . $e->getMessage(),
                'report_data' => $reportData
            );
        }
    } catch (Exception $e) {
        logError("=== Report generation failed ===");
        logError("Error: " . $e->getMessage());
        logError("Stack trace: " . $e->getTraceAsString());
        return array(
            'success' => false,
            'message' => 'Error generating report: ' . $e->getMessage()
        );
    }
}
?>