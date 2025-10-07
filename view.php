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
    <title>View Application - Frappéy</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #fff; }
        .header { 
            background: #000; 
            color: white; 
            padding: 20px 40px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .header img {
            height: 50px;
            width: auto;
            filter: invert(1) brightness(2);
        }
        .container { 
            max-width: 900px; 
            margin: 40px auto; 
            background: white; 
            padding: 40px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 3px solid #000;
        }
        .section { 
            margin-bottom: 30px; 
            padding-bottom: 20px; 
            border-bottom: 3px solid #000; 
        }
        .section:last-child { border-bottom: none; }
        .section h2 { color: #000; margin-bottom: 20px; }
        .field { margin-bottom: 15px; }
        .field label { 
            display: block; 
            color: #666; 
            font-size: 0.9em; 
            margin-bottom: 5px; 
        }
        .field .value { color: #000; font-size: 1.1em; font-weight: 500; }
        .actions { display: flex; gap: 10px; margin-top: 30px; }
        .btn { 
            padding: 12px 30px; 
            border: 2px solid #000; 
            border-radius: 5px; 
            cursor: pointer; 
            text-decoration: none; 
            display: inline-block; 
            font-weight: 600;
            transition: all 0.3s;
        }
        .back-btn { background: #000; color: white; }
        .back-btn:hover { background: white; color: #000; }
        .print-btn { background: #666; color: white; border-color: #666; }
        .print-btn:hover { background: white; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <img src="assets/logo_main.png" alt="Frappéy Logo">
        <h1>Franchise Application Details</h1>
    </div>

    <div class="container">
        <div class="section">
            <h2>Personal Information</h2>
            <div class="field">
                <label>Full Name</label>
                <div class="value"><?php echo $app['given_name'] . ' ' . $app['middle_name'] . ' ' . $app['last_name']; ?></div>
            </div>
            <div class="field">
                <label>Date of Birth</label>
                <div class="value"><?php echo date('F d, Y', strtotime($app['date_of_birth'])); ?></div>
            </div>
            <div class="field">
                <label>Nationality</label>
                <div class="value"><?php echo $app['nationality']; ?></div>
            </div>
            <div class="field">
                <label>Civil Status</label>
                <div class="value"><?php echo $app['civil_status']; ?></div>
            </div>
            <div class="field">
                <label>Home Address</label>
                <div class="value"><?php echo $app['home_address']; ?></div>
            </div>
            <div class="field">
                <label>Proposed Business Location</label>
                <div class="value"><?php echo $app['proposed_location']; ?></div>
            </div>
            <div class="field">
                <label>Contact Number</label>
                <div class="value"><?php echo $app['contact_number']; ?></div>
            </div>
            <div class="field">
                <label>Email Address</label>
                <div class="value"><?php echo $app['email']; ?></div>
            </div>
        </div>

        <div class="section">
            <h2>Business Background</h2>
            <div class="field">
                <label>Occupation / Current Business</label>
                <div class="value"><?php echo $app['occupation']; ?></div>
            </div>
            <div class="field">
                <label>Company Name</label>
                <div class="value"><?php echo $app['company_name'] ?: 'N/A'; ?></div>
            </div>
            <div class="field">
                <label>Position / Role</label>
                <div class="value"><?php echo $app['position_role'] ?: 'N/A'; ?></div>
            </div>
            <div class="field">
                <label>Years in Current Job / Business</label>
                <div class="value"><?php echo $app['years_in_job'] ?: 'N/A'; ?></div>
            </div>
            <div class="field">
                <label>Ever Owned or Managed a Business</label>
                <div class="value"><?php echo $app['owned_business']; ?></div>
            </div>
            <?php if ($app['owned_business'] === 'Yes' && $app['owned_business_details']): ?>
            <div class="field">
                <label>Business Details</label>
                <div class="value"><?php echo $app['owned_business_details']; ?></div>
            </div>
            <?php endif; ?>
            <div class="field">
                <label>Food & Beverage Experience</label>
                <div class="value"><?php echo $app['fb_experience']; ?></div>
            </div>
            <?php if ($app['fb_experience'] === 'Yes' && $app['fb_experience_details']): ?>
            <div class="field">
                <label>F&B Experience Details</label>
                <div class="value"><?php echo $app['fb_experience_details']; ?></div>
            </div>
            <?php endif; ?>
        </div>

        <div class="section">
            <h2>Financial Capability</h2>
            <div class="field">
                <label>Available Capital for Investment</label>
                <div class="value"><?php echo $app['available_capital']; ?></div>
            </div>
            <div class="field">
                <label>Source of Investment Funds</label>
                <div class="value"><?php echo $app['fund_source']; ?><?php echo ($app['fund_source'] === 'Others' && $app['fund_source_other']) ? ' - ' . $app['fund_source_other'] : ''; ?></div>
            </div>
            <div class="field">
                <label>Preferred Ownership Type</label>
                <div class="value"><?php echo $app['ownership_type']; ?></div>
            </div>
            <div class="field">
                <label>How They Learned About Frappéy</label>
                <div class="value"><?php echo $app['learned_about']; ?><?php echo ($app['learned_about'] === 'Other' && $app['learned_about_other']) ? ' - ' . $app['learned_about_other'] : ''; ?></div>
            </div>
            <div class="field">
                <label>Submission Date</label>
                <div class="value"><?php echo date('F d, Y - h:i A', strtotime($app['submission_date'])); ?></div>
            </div>
        </div>

        <div class="actions">
            <a href="admin.php" class="btn back-btn">← Back to Dashboard</a>
            <a href="print.php?id=<?php echo $app['id']; ?>" target="_blank" class="btn print-btn">Print as PDF</a>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>