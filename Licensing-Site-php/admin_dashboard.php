<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit;
}

// Include your database connection logic here
require_once 'config.php';

// Function to retrieve and display license keys
function displayLicenseKeys($conn)
{
    $result = mysqli_query($conn, "SELECT * FROM license_keys");

    if ($result) {
        echo "<h3>License Keys:</h3>";
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>Key</th><th>Status(0 = Not Used, 1 = Used)</th></tr></thead>";
        echo "<tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['key_value']}</td>";
            echo "<td>{$row['is_used']}</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "Error retrieving license keys.";
    }
}

// Handle form submission for updating license key status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateStatus'])) {
    $keyId = $_POST['keyId'];
    $newStatus = $_POST['newStatus'];

    $updateQuery = mysqli_query($conn, "UPDATE license_keys SET is_used = '$newStatus' WHERE id = '$keyId'");

    if (!$updateQuery) {
        echo "Error updating license key status.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #343a40;
            color: #fff;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h2 {
            margin: 0;
        }

        .content-container {
            padding: 20px;
        }

        .btn-dark {
            background-color: #343a40;
            color: #fff;
        }

        .btn-dark:hover {
            background-color: #23282d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h2>Welcome, Admin <?php echo $_SESSION['username']; ?>! This is the Admin Dashboard</h2>
                <!-- Button to trigger the license key modal -->
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#generateKeysModal">
                    Generate License Keys
                </button>
            </div>
            <div class="content-container">
                <!-- Add Admin-specific content and functionality here -->

                <?php
                // Display existing license keys
                displayLicenseKeys($conn);
                ?>

                <!-- Add Logout Button -->
                <a href="logout.php" class="btn btn-dark">Logout</a>
            </div>
        </div>
    </div>

    <!-- License Key Generation Modal -->
    <div class="modal fade" id="generateKeysModal" tabindex="-1" role="dialog" aria-labelledby="generateKeysModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateKeysModalLabel">Generate License Keys</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for generating license keys -->
                    <form id="generateKeysForm" method="post" action="generate_keys.php">
                        <div class="form-group">
                            <label for="numberOfKeys">Number of Keys:</label>
                            <input type="number" class="form-control" id="numberOfKeys" name="numberOfKeys" required>
                        </div>
                        <div class="form-group">
                            <label for="keyFormat">Key Format:</label>
                            <input type="text" class="form-control" id="keyFormat" name="keyFormat" placeholder="e.g., custom-random-random" required>
                        </div>
                        <button type="submit" class="btn btn-dark">Generate Keys</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
