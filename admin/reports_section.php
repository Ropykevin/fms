<!-- Reports UI -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Generate Reports</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <?php foreach (['weekly', 'monthly'] as $type): ?>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= ucfirst($type) ?> Report</h5>
                            <p class="card-text">Generate and download the <?= $type ?> report.</p>
                            <button type="button" class="btn btn-primary generate-report-btn"
                                data-report-type="<?= $type ?>">
                                <i class="fas fa-file-alt"></i> Generate <?= ucfirst($type) ?> Report
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div id="reportStatus" class="mt-3"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const reportButtons = document.querySelectorAll('.generate-report-btn');

        reportButtons.forEach(button => {
            button.addEventListener('click', function () {
                const reportType = this.getAttribute('data-report-type');
                const statusDiv = document.getElementById('reportStatus');

                if (!statusDiv) {
                    console.error('Report status div not found');
                    return;
                }

                // Disable all buttons and show loading state
                reportButtons.forEach(btn => btn.disabled = true);
                statusDiv.innerHTML = `
                <div class="alert alert-info">
                    <i class="fas fa-spinner fa-spin"></i> Generating report, please wait...
                    <div class="mt-2">
                        <small class="text-muted">This may take a few moments...</small>
                    </div>
                </div>`;

                // Create form data
                const formData = new URLSearchParams();
                formData.append('action', reportType);

                // Log the request details
                console.log('Sending request:', {
                    url: 'admin/generate_reports.php',
                    method: 'POST',
                    data: formData.toString()
                });

                // Send AJAX request
                fetch('admin/generate_reports.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData,
                    credentials: 'same-origin'
                })
                    .then(async response => {
                        console.log('Response status:', response.status);
                        console.log('Response headers:', Object.fromEntries(response.headers.entries()));

                        // Get the response text first
                        const text = await response.text();
                        console.log('Raw response:', text);

                        // Try to parse as JSON
                        let data;
                        try {
                            data = JSON.parse(text);
                        } catch (e) {
                            console.error('Failed to parse JSON:', e);
                            throw new Error('Invalid JSON response from server');
                        }

                        if (!response.ok) {
                            throw new Error(data.message || `HTTP error! status: ${response.status}`);
                        }

                        return data;
                    })
                    .then(data => {
                        console.log('Parsed response data:', data);
                        if (data.success) {
                            statusDiv.innerHTML = `
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> ${data.message}
                        </div>`;
                        } else {
                            statusDiv.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> ${data.message}
                            <div class="mt-2">
                                <small class="text-muted">
                                    Please check the error logs at:<br>
                                    - logs/error.log<br>
                                    - logs/php_errors.log<br>
                                    - C:\\xampp\\php\\logs\\php_error.log
                                </small>
                            </div>
                        </div>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        statusDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> ${error.message}
                        <div class="mt-2">
                            <small class="text-muted">
                                Please check the error logs at:<br>
                                - logs/error.log<br>
                                - logs/php_errors.log<br>
                                - C:\\xampp\\php\\logs\\php_error.log
                            </small>
                        </div>
                    </div>`;
                    })
                    .finally(() => {
                        // Re-enable all report buttons
                        reportButtons.forEach(btn => btn.disabled = false);
                    });
            });
        });
    });
</script>