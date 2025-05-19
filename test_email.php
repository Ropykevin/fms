<?php
require_once 'mail_functions.php';

// Test data for a feeding report
$testData = [
    'Report ID' => 'TEST001',
    'Animal ID' => 'TEST123',
    'Feeding Date' => date('Y-m-d'),
    'Feed Type' => 'Test Feed',
    'Quantity' => '10 kg',
    'Remarks' => 'This is a test email notification'
];

// Try to send the test email
if (sendReportNotification('Test Feeding', $testData)) {
    echo "Test email sent successfully! Please check your inbox at kevinropy@gmail.com";
} else {
    echo "Failed to send test email. Check the error logs for details.";
}
?>