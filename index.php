<?php
require_once 'config.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("INSERT INTO franchise_applications (
        last_name, given_name, middle_name, date_of_birth, nationality, 
        civil_status, home_address, proposed_location, contact_number, 
        email, occupation, company_name, position_role, years_in_job, 
        owned_business, owned_business_details, fb_experience, 
        fb_experience_details, available_capital, fund_source, 
        fund_source_other, ownership_type, learned_about, learned_about_other
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("ssssssssssssssssssssssss",
        $_POST['last_name'], $_POST['given_name'], $_POST['middle_name'],
        $_POST['date_of_birth'], $_POST['nationality'], $_POST['civil_status'],
        $_POST['home_address'], $_POST['proposed_location'], $_POST['contact_number'],
        $_POST['email'], $_POST['occupation'], $_POST['company_name'],
        $_POST['position_role'], $_POST['years_in_job'], $_POST['owned_business'],
        $_POST['owned_business_details'], $_POST['fb_experience'],
        $_POST['fb_experience_details'], $_POST['available_capital'],
        $_POST['fund_source'], $_POST['fund_source_other'], $_POST['ownership_type'],
        $_POST['learned_about'], $_POST['learned_about_other']
    );
    
    if ($stmt->execute()) {
        $success = true;
    } else {
        $error = "Error submitting application. Please try again.";
    }
    
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frappéy Franchise Application</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #fff;
            min-height: 100vh; 
            padding: 20px; 
        }
        .container { 
            max-width: 800px; 
            margin: 0 auto; 
            background: white; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            border: 3px solid #000;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
            padding-bottom: 20px; 
    
        }
        .header img {
            max-width: 200px;
            height: auto;
            margin-bottom: 15px;
        }
        .header h1 { color: #000; font-size: 2.5em; margin-bottom: 10px; }
        .header p { color: #666; font-size: 1.1em; }
        .section { margin-bottom: 30px; }
        .section h2 { 
            color: #000; 
            margin-bottom: 20px; 
            font-size: 1.5em; 
            padding-bottom: 10px; 
    
        }
        .form-group { margin-bottom: 20px; }
        .form-group label { 
            display: block; 
            margin-bottom: 8px; 
            color: #000; 
            font-weight: 600; 
        }
        .form-group input[type="text"], 
        .form-group input[type="email"], 
        .form-group input[type="date"], 
        .form-group input[type="tel"], 
        .form-group textarea, 
        .form-group select { 
            width: 100%; 
            padding: 12px; 
            border: 3px solid #000; 
            border-radius: 8px; 
            font-size: 1em; 
            transition: all 0.3s; 
        }
        .form-group input:focus, 
        .form-group textarea:focus, 
        .form-group select:focus { 
            outline: none; 
            border-color: #000; 
            box-shadow: 0 0 0 3px rgba(0,0,0,0.1);
        }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .form-row { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 20px; 
        }
        .checkbox-group { 
            display: flex; 
            gap: 20px; 
            margin-top: 10px; 
        }
        .checkbox-group label { 
            display: flex; 
            align-items: center; 
            gap: 8px; 
            font-weight: normal; 
        }
        .conditional-field { 
            margin-top: 15px; 
            padding: 15px; 
            background: #f8f9fa; 
            border-radius: 8px; 
            display: none;
            border: 3px solid #000;
        }
        .conditional-field.active { display: block; }
        .submit-btn { 
            background: #000; 
            color: white; 
            padding: 15px 40px; 
            border: 3px solid #000; 
            border-radius: 8px; 
            font-size: 1.1em; 
            font-weight: 600; 
            cursor: pointer; 
            width: 100%; 
            transition: all 0.3s; 
        }
        .submit-btn:hover { 
            background: white;
            color: #000;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        .success-message { 
            background: #d4edda; 
            color: #155724; 
            padding: 20px; 
            border-radius: 8px; 
            margin-bottom: 20px; 
            border: 3px solid #000; 
        }
        .error-message { 
            background: #f8d7da; 
            color: #721c24; 
            padding: 20px; 
            border-radius: 8px; 
            margin-bottom: 20px; 
            border: 3px solid #000; 
        }
        .admin-link { text-align: center; margin-top: 20px; }
        .admin-link a { 
            color: #000; 
            text-decoration: none; 
            font-weight: 600;
        }
        .admin-link a:hover { 
            color: #666;
            border-bottom-color: #666;
        }
        @media (max-width: 768px) { 
            .form-row { grid-template-columns: 1fr; } 
            .container { padding: 20px; } 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="assets/logo_main.png" alt="Frappéy Logo">
            <p>Franchise Application Form</p>
        </div>

        <?php if ($success): ?>
            <div class="success-message">
                <strong>Success!</strong> Your franchise application has been submitted successfully. We will contact you soon.
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error-message">
                <strong>Error!</strong> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="section">
                <h2>Personal Information</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Last Name *</label>
                        <input type="text" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label>Given Name *</label>
                        <input type="text" name="given_name" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" name="middle_name">
                    </div>
                    <div class="form-group">
                        <label>Date of Birth *</label>
                        <input type="date" name="date_of_birth" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Nationality *</label>
                        <input type="text" name="nationality" required>
                    </div>
                    <div class="form-group">
                        <label>Civil Status *</label>
                        <select name="civil_status" required>
                            <option value="">Select...</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Separated">Separated</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Home Address *</label>
                    <textarea name="home_address" required></textarea>
                </div>

                <div class="form-group">
                    <label>Proposed Business Location *</label>
                    <textarea name="proposed_location" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Contact Number *</label>
                        <input type="tel" name="contact_number" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="email" required>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>Business Background</h2>
                
                <div class="form-group">
                    <label>Occupation / Current Business *</label>
                    <input type="text" name="occupation" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" name="company_name">
                    </div>
                    <div class="form-group">
                        <label>Position / Role</label>
                        <input type="text" name="position_role">
                    </div>
                </div>

                <div class="form-group">
                    <label>Years in Current Job / Business</label>
                    <input type="text" name="years_in_job">
                </div>

                <div class="form-group">
                    <label>Have you ever owned or managed a business? *</label>
                    <div class="checkbox-group">
                        <label><input type="radio" name="owned_business" value="Yes" onchange="toggleField('owned_business_field', this.value === 'Yes')" required> Yes</label>
                        <label><input type="radio" name="owned_business" value="No" onchange="toggleField('owned_business_field', this.value === 'Yes')" required> No</label>
                    </div>
                    <div id="owned_business_field" class="conditional-field">
                        <label>Please specify:</label>
                        <textarea name="owned_business_details"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label>Do you have experience in the food & beverage industry? *</label>
                    <div class="checkbox-group">
                        <label><input type="radio" name="fb_experience" value="Yes" onchange="toggleField('fb_experience_field', this.value === 'Yes')" required> Yes</label>
                        <label><input type="radio" name="fb_experience" value="No" onchange="toggleField('fb_experience_field', this.value === 'Yes')" required> No</label>
                    </div>
                    <div id="fb_experience_field" class="conditional-field">
                        <label>Please specify:</label>
                        <textarea name="fb_experience_details"></textarea>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>Financial Capability</h2>
                
                <div class="form-group">
                    <label>Available Capital for Investment *</label>
                    <input type="text" name="available_capital" placeholder="e.g., ₱500,000" required>
                </div>

                <div class="form-group">
                    <label>Source of Investment Funds *</label>
                    <div class="checkbox-group">
                        <label><input type="radio" name="fund_source" value="Savings" onchange="toggleField('fund_source_field', this.value === 'Others')" required> Savings</label>
                        <label><input type="radio" name="fund_source" value="Loan" onchange="toggleField('fund_source_field', this.value === 'Others')" required> Loan</label>
                        <label><input type="radio" name="fund_source" value="Investor/Partner" onchange="toggleField('fund_source_field', this.value === 'Others')" required> Investor/Partner</label>
                        <label><input type="radio" name="fund_source" value="Others" onchange="toggleField('fund_source_field', this.value === 'Others')" required> Others</label>
                    </div>
                    <div id="fund_source_field" class="conditional-field">
                        <label>Please specify:</label>
                        <input type="text" name="fund_source_other">
                    </div>
                </div>

                <div class="form-group">
                    <label>Would you prefer: *</label>
                    <div class="checkbox-group">
                        <label><input type="radio" name="ownership_type" value="Sole Ownership" required> Sole Ownership</label>
                        <label><input type="radio" name="ownership_type" value="Partnership" required> Partnership</label>
                        <label><input type="radio" name="ownership_type" value="Corporation" required> Corporation</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>How did you learn about Frappéy? *</label>
                    <div class="checkbox-group">
                        <label><input type="radio" name="learned_about" value="Social Media" onchange="toggleField('learned_about_field', this.value === 'Other')" required> Social Media</label>
                        <label><input type="radio" name="learned_about" value="Friend Referral" onchange="toggleField('learned_about_field', this.value === 'Other')" required> Friend Referral</label>
                        <label><input type="radio" name="learned_about" value="Event/Branch" onchange="toggleField('learned_about_field', this.value === 'Other')" required> Event/Branch</label>
                        <label><input type="radio" name="learned_about" value="Other" onchange="toggleField('learned_about_field', this.value === 'Other')" required> Other</label>
                    </div>
                    <div id="learned_about_field" class="conditional-field">
                        <label>Please specify:</label>
                        <input type="text" name="learned_about_other">
                    </div>
                </div>
            </div>

            <button type="submit" class="submit-btn">Submit Application</button>
        </form>

        <div class="admin-link">
            <a href="login.php">Admin Login</a>
        </div>
    </div>

    <script>
        function toggleField(fieldId, show) {
            const field = document.getElementById(fieldId);
            if (show) {
                field.classList.add('active');
            } else {
                field.classList.remove('active');
            }
        }
    </script>
</body>
</html>