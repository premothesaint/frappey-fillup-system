<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$conn = getDBConnection();
$result = $conn->query("SELECT * FROM franchise_applications ORDER BY submission_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Frappéy</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .header { 
            background: #000; 
            color: white; 
            padding: 20px 40px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .header-left img {
            height: 50px;
            width: auto;
        }
        .header h1 { font-size: 1.8em; }
        .logout-btn { 
            background: white; 
            color: #000; 
            padding: 10px 20px; 
            border: 2px solid white; 
            border-radius: 5px; 
            cursor: pointer; 
            font-weight: 600; 
            text-decoration: none;
            transition: all 0.3s;
        }
        .logout-btn:hover {
            background: #000;
            color: white;
        }
        .container { padding: 40px; }
        .delete-btn { background: #000; color: white; border: 2px solid #000; }
        .delete-btn:hover { background: #fff; color: #000; }
        .stats { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 20px; 
            margin-bottom: 30px; 
        }
        .stat-card { 
            background: white; 
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 2px solid #000;
        }
        .stat-card h3 { color: #666; font-size: 0.9em; margin-bottom: 10px; }
        .stat-card .number { font-size: 2em; color: #000; font-weight: 700; }
        .table-container { 
            background: white; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
            overflow: hidden;
            border: 2px solid #000;
        }
        table { width: 100%; border-collapse: collapse; }
        th { 
            background: #000; 
            color: white; 
            padding: 15px; 
            text-align: left; 
            font-weight: 600; 
        }
        td { padding: 15px; border-bottom: 1px solid #eee; }
        tr:hover { background: #f8f9fa; }
        .action-btn { 
            padding: 8px 15px; 
            border: 2px solid #000; 
            border-radius: 5px; 
            cursor: pointer; 
            margin-right: 5px; 
            text-decoration: none; 
            display: inline-block; 
            font-size: 0.9em;
            transition: all 0.3s;
        }
        .view-btn { background: #000; color: white; }
        .view-btn:hover { background: white; color: #000; }
        .print-btn { background: #666; color: white; border-color: #666; }
        .print-btn:hover { background: white; color: #666; }
        .no-data { text-align: center; padding: 40px; color: #999; }
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 2px solid #000;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <img src="assets/logo_main2.png" alt="Frappéy Logo">
            <h1>Admin Dashboard</h1>
        </div>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="container">
        <?php if (isset($_GET['deleted'])): ?>
            <div class="success-message">
                <strong>✓</strong> Application deleted successfully!
            </div>
        <?php endif; ?>

        <div class="stats">
            <div class="stat-card">
                <h3>Total Applications</h3>
                <div class="number"><?php echo $result->num_rows; ?></div>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Submission Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['given_name'] . ' ' . $row['last_name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['contact_number']; ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['submission_date'])); ?></td>
                                <td>
                                    <a href="view.php?id=<?php echo $row['id']; ?>" class="action-btn view-btn">View</a>
                                    <a href="print.php?id=<?php echo $row['id']; ?>" target="_blank" class="action-btn print-btn">Print PDF</a>
                                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="action-btn delete-btn" onclick="return confirm('⚠️ Are you sure you want to delete this application? This action cannot be undone.');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="no-data">No applications yet</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>