<?php
// Include your database connection logic here
require_once 'config.php';

// Assuming you are using POST method to submit the license key
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['license_key'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $licenseKey = mysqli_real_escape_string($conn, $_POST['license_key']);

  // Check if the license key exists and is not used
  $query = mysqli_query($conn, "SELECT * FROM license_keys WHERE key_value = '$licenseKey' AND is_used = 0");

  if ($query) {
      $result = mysqli_fetch_assoc($query);

      // Mark the license key as used
      mysqli_query($conn, "UPDATE license_keys SET is_used = 1 WHERE id = " . $result['id']);

      // Insert user data into the 'users' table
      $insertUserQuery = mysqli_query($conn, "INSERT INTO users (username, password, license_key) VALUES ('$username', '$password', '$licenseKey')");

      if ($insertUserQuery) {
          // Successfully registered the user
          echo "User registered successfully. You can now log in.";
      } else {
          // Error registering the user
          echo "Error registering user: " . mysqli_error($conn);
      }
  } else {
      // License key not found or already used
      echo "Invalid or used license key.";
  }
} elseif (isset($_POST['login'])) {
        // Handle login
        $username = $_POST['username'];
        $password = $_POST['password'];

        $selectUserQuery = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

        if ($selectUserQuery && mysqli_num_rows($selectUserQuery) === 1) {
            $user = mysqli_fetch_assoc($selectUserQuery);

            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['is_admin'] = $user['is_admin'];
                header($user['is_admin'] ? 'Location: admin_dashboard.php' : 'Location: user_dashboard.php');
                exit;
            }
        }

        $error = 'Invalid username or password.';
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login/Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card mt-5">
            <div class="header">
                <h2>Login/Register</h2>
            </div>
            <div class="form-container">
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="index.php" method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <div class="input-group">
                            <div class="input-group-addon">@</div>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="license_key">License Key (for registration):</label>
                        <input type="text" class="form-control" name="license_key">
                    </div>

                    <button type="submit" class="btn btn-dark" name="login">Login</button>
                    <button type="submit" class="btn btn-dark" name="register">Register</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
