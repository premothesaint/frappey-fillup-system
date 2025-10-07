<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];
$conn = getDBConnection();
$stmt = $conn->prepare("SELECT * FROM franchise_applications WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$app = $result->fetch_assoc();

if (!$app) {
    die("Application not found");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Franchise Application - <?php echo $app['given_name'] . ' ' . $app['last_name']; ?></title>
<style>
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 0; }
            .container { padding: 15px; border: 2px solid #000; max-width: 100%; margin: 0; }
            
            /* Force preserve grid layouts - NO AUTO ADJUSTMENTS */
            .form-row { 
                display: grid !important; 
                grid-template-columns: repeat(4, 1fr) !important; 
                gap: 8px !important;
                page-break-inside: avoid;
                margin-bottom: 15px !important;
            }
            .form-row.row-2 { 
                grid-template-columns: 1fr 1fr !important; 
            }
            .form-row.row-3 { 
                grid-template-columns: 2fr 1fr 1fr !important; 
            }
            .form-row.full { 
                grid-template-columns: 1fr !important; 
            }
            
            .form-field { 
                display: flex !important; 
                flex-direction: column !important; 
            }
            .form-field label {
                font-size: 0.7em !important;
                margin-bottom: 5px !important;
            }
            .form-field .input-box { 
                border: 1px solid #000; 
                min-height: 26px !important;
                padding: 4px 6px !important;
                display: flex;
                align-items: center;
                word-break: break-word;
                font-size: 0.85em !important;
            }
            .section-header { 
                background: #000 !important; 
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                page-break-after: avoid;
                padding: 5px 10px !important;
                margin: 10px 0 6px 0 !important;
                font-size: 0.9em !important;
            }
            .checkbox-item .box { 
                border: 1px solid #000;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .checkbox-item .box.checked { 
                background: #000;
                color: white;
            }
            .checkbox-group {
                display: flex !important;
                flex-direction: row !important;
                gap: 15px !important;
            }
            .form-header { 
                border-bottom: 1px solid #000;
                display: flex !important;
                justify-content: space-between !important;
                margin-bottom: 8px !important;
                padding-bottom: 8px !important;
            }
            .form-title {
                margin-bottom: 15px !important;
                font-size: 1em !important;
            }
            .app-id {
                margin-bottom: 15px !important;
                font-size: 0.8em !important;
            }
            .footer { 
                border-top: 1px solid #000;
                margin-top: 15px !important;
                padding-top: 8px !important;
                font-size: 0.75em !important;
            }
            .footer p {
                margin-top: 5px !important;
            }
            
            /* Override any responsive behavior */
            @page { size: letter; margin: 0.3in; }
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border: 2px solid #000; }
        
        .form-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #ccc; }
        .logo-section { font-size: 0.85em; color: #666; }
        .company-name { font-size: 1.4em; font-weight: bold; color: #000; }
        .form-title { font-size: 1.1em; font-weight: bold; margin-bottom: 15px; }
        .app-id { text-align: right; font-size: 0.85em; color: #666; margin-bottom: 10px; }
        
        .section-header { background: #000; color: white; padding: 6px 12px; font-size: 0.95em; font-weight: bold; margin: 15px 0 10px 0; }
        
        .form-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 8px; }
        .form-row.row-2 { grid-template-columns: 1fr 1fr; }
        .form-row.row-3 { grid-template-columns: 2fr 1fr 1fr; }
        .form-row.full { grid-template-columns: 1fr; }
        
        .form-field { display: flex; flex-direction: column; }
        .form-field label { font-size: 0.75em; font-weight: bold; color: #333; margin-bottom: 2px; }
        .form-field .input-box { border: 1px solid #000; padding: 6px 8px; min-height: 28px; font-size: 0.9em; background: white; }
        
        .checkbox-group { display: flex; gap: 15px; align-items: center; }
        .checkbox-item { display: flex; align-items: center; gap: 5px; }
        .checkbox-item .box { width: 14px; height: 14px; border: 1px solid #000; display: inline-flex; align-items: center; justify-content: center; font-size: 0.85em; }
        .checkbox-item .box.checked::after { content: '✓'; }
        
        .print-btn-container { text-align: center; margin: 20px 0; }
        .print-btn { background: #000; color: white; padding: 12px 35px; border: none; cursor: pointer; font-size: 1em; font-weight: 600; }
        .print-btn:hover { background: #333; }
        
        .footer { margin-top: 20px; padding-top: 10px; border-top: 1px solid #ccc; text-align: center; font-size: 0.8em; color: #666; }
        
        @media (max-width: 768px) {
            .form-row, .form-row.row-2, .form-row.row-3 { grid-template-columns: 1fr; }
        }
        
        /* DISABLE mobile/responsive for print */
        @media print {
            @media (max-width: 768px) {
                .form-row { grid-template-columns: repeat(4, 1fr) !important; }
                .form-row.row-2 { grid-template-columns: 1fr 1fr !important; }
                .form-row.row-3 { grid-template-columns: 2fr 1fr 1fr !important; }
            }
        }
    </style>
</head>
<body>
    <div class="print-btn-container no-print">
        <button onclick="window.print()" class="print-btn">🖨️ PRINT / SAVE AS PDF</button>
    </div>

    <div class="container">
        <div class="form-header">
            <div class="logo-section">
            <img src="./assets/logo.png" alt="Frappéy Logo" style="max-width: 150px; height: auto;">
            </div>
                 <div class="company-name">Franchise Info</div>
            </div>
        <div class="section-header">Applicant Information</div>

        <div class="form-row">
            <div class="form-field">
                <label>Last Name</label>
                <div class="input-box"><?php echo $app['last_name']; ?></div>
            </div>
            <div class="form-field">
                <label>First Name</label>
                <div class="input-box"><?php echo $app['given_name']; ?></div>
            </div>
            <div class="form-field">
                <label>M.I.</label>
                <div class="input-box"><?php echo $app['middle_name'] ?: ''; ?></div>
            </div>
            <div class="form-field">
                <label>Date of Birth</label>
                <div class="input-box"><?php echo date('m/d/Y', strtotime($app['date_of_birth'])); ?></div>
            </div>
        </div>

        <div class="form-row full">
            <div class="form-field">
                <label>Home Address</label>
                <div class="input-box"><?php echo $app['home_address']; ?></div>
            </div>
        </div>

        <div class="form-row row-3">
            <div class="form-field">
                <label>Nationality</label>
                <div class="input-box"><?php echo $app['nationality']; ?></div>
            </div>
            <div class="form-field">
                <label>Civil Status</label>
                <div class="input-box"><?php echo $app['civil_status']; ?></div>
            </div>
            <div class="form-field">
                <label>Contact Number</label>
                <div class="input-box"><?php echo $app['contact_number']; ?></div>
            </div>
        </div>

        <div class="form-row row-2">
            <div class="form-field">
                <label>Email Address</label>
                <div class="input-box"><?php echo $app['email']; ?></div>
            </div>
            <div class="form-field">
                <label>Proposed Business Location</label>
                <div class="input-box"><?php echo $app['proposed_location']; ?></div>
            </div>
        </div>

        <div class="section-header">Business Background</div>

        <div class="form-row row-2">
            <div class="form-field">
                <label>Occupation / Current Business</label>
                <div class="input-box"><?php echo $app['occupation']; ?></div>
            </div>
            <div class="form-field">
                <label>Company Name</label>
                <div class="input-box"><?php echo $app['company_name'] ?: ''; ?></div>
            </div>
        </div>

        <div class="form-row row-2">
            <div class="form-field">
                <label>Position / Role</label>
                <div class="input-box"><?php echo $app['position_role'] ?: ''; ?></div>
            </div>
            <div class="form-field">
                <label>Years in Current Job / Business</label>
                <div class="input-box"><?php echo $app['years_in_job'] ?: ''; ?></div>
            </div>
        </div>

        <div class="form-row full">
            <div class="form-field">
                <label>Have you ever owned or managed a business?</label>
                <div class="input-box">
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <div class="box <?php echo $app['owned_business'] === 'Yes' ? 'checked' : ''; ?>"></div>
                            <span>YES</span>
                        </div>
                        <div class="checkbox-item">
                            <div class="box <?php echo $app['owned_business'] === 'No' ? 'checked' : ''; ?>"></div>
                            <span>NO</span>
                        </div>
                        <?php if ($app['owned_business'] === 'Yes' && $app['owned_business_details']): ?>
                            <span style="margin-left: 15px;">Details: <?php echo $app['owned_business_details']; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-row full">
            <div class="form-field">
                <label>Do you have experience in the food & beverage industry?</label>
                <div class="input-box">
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <div class="box <?php echo $app['fb_experience'] === 'Yes' ? 'checked' : ''; ?>"></div>
                            <span>YES</span>
                        </div>
                        <div class="checkbox-item">
                            <div class="box <?php echo $app['fb_experience'] === 'No' ? 'checked' : ''; ?>"></div>
                            <span>NO</span>
                        </div>
                        <?php if ($app['fb_experience'] === 'Yes' && $app['fb_experience_details']): ?>
                            <span style="margin-left: 15px;">Details: <?php echo $app['fb_experience_details']; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-header">Financial Capability</div>

        <div class="form-row row-2">
            <div class="form-field">
                <label>Available Capital for Investment</label>
                <div class="input-box"><?php echo $app['available_capital']; ?></div>
            </div>
            <div class="form-field">
                <label>Source of Investment Funds</label>
                <div class="input-box"><?php echo $app['fund_source']; ?><?php if ($app['fund_source'] === 'Others' && $app['fund_source_other']) echo ': ' . $app['fund_source_other']; ?></div>
            </div>
        </div>

        <div class="form-row row-2">
            <div class="form-field">
                <label>Ownership Type Preference</label>
                <div class="input-box"><?php echo $app['ownership_type']; ?></div>
            </div>
            <div class="form-field">
                <label>How did you learn about Frappéy?</label>
                <div class="input-box"><?php echo $app['learned_about']; ?><?php if ($app['learned_about'] === 'Other' && $app['learned_about_other']) echo ': ' . $app['learned_about_other']; ?></div>
            </div>
        </div>

        <div class="footer">
            <p>Submitted on: <?php echo date('F d, Y - h:i A', strtotime($app['submission_date'])); ?></p>
            <p style="margin-top: 8px;">© <?php echo date('Y'); ?> Frappéy - All Rights Reserved</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            if (window.location.search.includes('auto=1')) {
                setTimeout(() => window.print(), 500);
            }
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>