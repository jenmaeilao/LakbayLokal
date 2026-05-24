<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - LakbayPH</title>
</head>
<body>

  <h2>Create Account</h2>

  <form action="auth/register-process.php" method="POST">
    <input type="text" name="fullname" placeholder="Full name" required>
    <input type="email" name="email" placeholder="Email address" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm password" required>
    <button type="submit">Create Account</button>
  </form>

  <p>Already have an account? <a href="login.php">Login</a></p>

</body>
</html>