<?php
@include 'config.php';

if(isset($_POST['submit'])){
   $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

    // Check if the username contains spaces
    if (strpos($user_id, ' ') !== false) {
      $error[] = 'Username cannot contain spaces.';
   }

  // Check if the username already exists
  $checkUsernameQuery = "SELECT * FROM user_form WHERE user_id = '$user_id'";
  $result = mysqli_query($conn, $checkUsernameQuery);

  if (mysqli_num_rows($result) > 0) {
      $error[] = 'Username already exists.';
  }

  if (empty($error)) {
      if ($pass != $cpass) {
          $error[] = 'Passwords do not match.';
      } else {
          // Set approval status for customer accounts (user_type == 'user') to 0 (pending)
          $approval_status = ($user_type == 'user') ? 0 : 1;

          $insert = "INSERT INTO user_form(user_id, name, email, password, user_type, approval) VALUES('$user_id','$name','$email','$pass','$user_type','$approval_status')";
          mysqli_query($conn, $insert);

           // Set the 'name' in the session
        $_SESSION['name'] = $name;

          header('location: login1.php');
      }
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style1.css">
   <style>
      .password-container {
         position: relative;
      }

      .show-password {
         position: absolute;
         top: 50%;
         right: 10px;
         transform: translateY(-50%);
         cursor: pointer;
      }

      header {
         background-color: #eee;
         padding: 20px;
         text-align: center;
         color: #3498db;
      }

      header img {
         margin-right: 10px;
      }
   </style>

</head>
<body>

<header>
    <div style="display: flex; align-items: center; justify-content: center;">
        <img src="images/logo.png" alt="" width="85" height="65.25" style="margin-right: 10px;">
        <h1 style="margin: 0;">GRADIENT SOLUTION SERVICE LOG</h1>
    </div>
</header>
   
<div class="form-container">
   <form action="" method="post">
      <h3>register now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="user_id" required placeholder="enter your username">
      <input type="text" name="name" required placeholder="enter your name">
      <input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required placeholder="enter your email">
      <div class="password-container">
      <input type="password" name="password" pattern="(?=.*\d)(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase letter, and at least 8 or more characters" required placeholder="Enter your password">
      <span class="show-password" onclick="togglePasswordVisibility(this)">👁️</span>
      </div>
      <div class="password-container">
      <input type="password" name="cpassword" required placeholder="confirm your password">
      <span class="show-password" onclick="togglePasswordVisibility(this)">👁️</span>
      </div>
      <select name="user_type">
         <option value="user">Customer</option>
         <option value="admin">Worker</option>
      </select>
      <input type="hidden" name="approval" value="0">
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>already have an account? <a href="login1.php">login now</a></p>
   </form>

</div>

<!--See password-->
<script>
   function togglePasswordVisibility(icon) {
      const passwordField = icon.previousElementSibling;
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);
   }
</script>

</body>
</html>