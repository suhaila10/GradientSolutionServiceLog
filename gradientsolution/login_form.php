<?php

@include 'config.php';
session_start();

if(isset($_POST['submit'])){
   $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
   $pass = md5($_POST['password']);

   $select = "SELECT user_id, user_type FROM user_form WHERE user_id = '$user_id' AND password = '$pass'";
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_array($result);
      
      // Set user_id in the session
      $_SESSION['user_id'] = $row['user_id'];

      if($row['user_type'] == 'admin'){
         $_SESSION['admin_name'] = $row['name'];
         header('location:adminreply_enquiry.php');
      } elseif($row['user_type'] == 'user'){
         $_SESSION['user_name'] = $row['name'];
         header('location: display_records.php'); // Redirect to display_records.php
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
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style1.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="user_id" required placeholder="enter your user id">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>don't have an account? <a href="register_form.php">register now</a></p>
   </form>

</div>

</body>
</html>