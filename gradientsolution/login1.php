<?php
@include 'config.php';
session_start();
if(isset($_POST['submit'])){
   $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
   $pass = md5($_POST['password']);

   $select = "SELECT user_id, user_type, approval, name FROM user_form WHERE user_id = '$user_id' AND password = '$pass'";
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_array($result);

      $user_type = $row['user_type'];
      $approval = $row['approval'];

      if ($user_type == 'admin') {
         // Workers (admin) can log in without approval
         $_SESSION['user_id'] = $row['user_id'];
         $_SESSION['user_type'] = $user_type;
         $_SESSION['admin_name'] = $row['name'];
         header('location: admin_dashboard.php');
      } elseif ($user_type == 'user' && $approval == 1) {
         // Customers (user) can log in if their account is approved (approval status = 1)
         $_SESSION['user_id'] = $row['user_id'];
         $_SESSION['user_type'] = $user_type;
         $_SESSION['user_name'] = $row['name']; // 'name' is now set in the login code
         header('location: userdashboard.php');
      } elseif ($user_type == 'user' && $approval == 0) {
         $error[] = 'Your account is pending approval. Please wait for admin approval.';
      }
   } else {
      $error[] = 'Incorrect user ID or password!';
   }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE, edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>

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
   <h3>login now</h3>
      <?php
      if (isset($error)) {
         foreach ($error as $error) {
            echo '<span class="error-msg">' . $error . '</span>';
         };
      };
      ?>
      <input type="text" name="user_id" required placeholder="enter your username">
      <div class="password-container">
      <input type="password" name="password" required placeholder="enter your password">
      <span class="show-password" onclick="togglePasswordVisibility(this)">👁️</span>
      </div>
      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>don't have an account? <a href="register_form.php">register now</a></p>
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
