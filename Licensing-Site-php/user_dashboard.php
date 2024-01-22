<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'];
$is_admin = $_SESSION['is_admin'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
            </div>
            <div class="dashboard-content">
                <!-- Display changelogs (placeholder) -->
                <div>
                    <h3>Changelogs</h3>
                    <p>Changelog 1.0: Lorem ipsum dolor sit amet.</p>
                    <p>Changelog 2.0: Consectetur adipiscing elit.</p>
                </div>

                <!-- Display program download link (placeholder) -->
                <div>
                    <h3>Download Program</h3>
                    <p><a href="#">Download Now</a></p>
                </div>

                <!-- Display user status (placeholder) -->
                <div>
                    <h3>Status</h3>
                    <p>Your current status: Active</p>
                </div>

                <!-- Logout and Discord buttons -->
                <a class="btn btn-danger logout-btn" href="logout.php">Logout</a>
                <a class="btn btn-primary discord-btn" href="#">Discord</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
