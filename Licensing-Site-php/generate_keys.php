<?php
// Include your database connection logic here
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numberOfKeys']) && isset($_POST['keyFormat'])) {
    $numberOfKeys = $_POST['numberOfKeys'];
    $keyFormat = $_POST['keyFormat'];

    // Add your logic here to generate and insert license keys into the database
    for ($i = 0; $i < $numberOfKeys; $i++) {
        $licenseKey = generateLicenseKey($keyFormat);
        insertLicenseKey($conn, $licenseKey);
    }

    // You can redirect to the admin dashboard or any other page after generating keys
    header("Location: admin_dashboard.php");
    exit;
}

function generateLicenseKey($format)
{
    // Generate random numbers and characters
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $keyLength = strlen($chars);
    $key = '';

    for ($i = 0; $i < strlen($format); $i++) {
        if ($format[$i] === 'r') {
            $key .= $chars[rand(0, $keyLength - 1)];
        } else {
            $key .= $format[$i];
        }
    }

    return $key;
}

function insertLicenseKey($conn, $key)
{
    // Update the column names based on your actual database schema
    $insertQuery = mysqli_query($conn, "INSERT INTO license_keys (key_value, is_used) VALUES ('$key', 0)");

    if (!$insertQuery) {
        echo "Error inserting license key: " . mysqli_error($conn) . "<br>";
        echo "Generated Key: $key";
    }
}
?>
